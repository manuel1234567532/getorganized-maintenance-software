<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\MachineType;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Anzahl der offenen und in Bearbeitung befindlichen Tasks abrufen
         $openTasksCount = Task::whereIn('status', ['offen', 'in bearbeitung'])->count();

         // Anzahl der Tasks in Bearbeitung abrufen
         $inProgressTasksCount = Task::where('status', 'in bearbeitung')->count();
 
         // Anzahl der abgeschlossenen Tasks abrufen
         $completedTasksCount = Task::where('status', 'Abgeschlossen')->count();
 
         // Die Werte an die Ansicht übergeben
         return view('backend.task.index', compact('openTasksCount', 'inProgressTasksCount', 'completedTasksCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $machinesWithoutType = Machine::whereNull('machine_type_id')->get();
        $machineTypes = MachineType::with('machines')->get(); // Get all machine types with their machines
        $priorities = Priority::all();

        return view('backend.task.modal', [
            'machinesWithoutType' => $machinesWithoutType,
            'machineTypes' => $machineTypes,
            'priorities' => $priorities,
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_id' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        // dd($request->all());
        try {
            DB::beginTransaction();
            $loggedInUserName = Auth::user()->id;
            $tasks = Task::create([
                'machine_id' => $request->machine_id,
                'problem' => $request->problem,
                'user_id' => $loggedInUserName,
                'priority_id' => $request->priority_id,
                'status' => isset($request->status) ? $request->status : 'offen',
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Aufgabe erfolgreich erstellt.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('machine:id,name', 'priority:id,name')->findOrFail($id);
        $machines = Machine::all();
        $priorities = Priority::all();
        return view('backend.task.showtask', compact('task', 'machines', 'priorities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    $task = Task::with('machine:id,name', 'priority:id,name')->findOrFail($id);

    // Get machines without a type
    $machinesWithoutType = Machine::whereNull('machine_type_id')->get();

    // Get machine types with their machines
    $machineTypes = MachineType::with('machines')->get();

    // Get all priorities
    $priorities = Priority::all();

    // Pass everything to the view, using 'modal2.blade.php' instead of 'modal.blade.php'
    return view('backend.task.modal', [
        'task' => $task,
        'machinesWithoutType' => $machinesWithoutType,
        'machineTypes' => $machineTypes,
        'priorities' => $priorities,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'machine_id' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $loggedInUserName = Auth::user()->id;
            $task = Task::findOrFail($id);
            $task->update([
                'machine_id' => $request->machine_id,
                'problem' => $request->problem,
                'priority_id' => $request->priority_id,
                'status' => $request->status,
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Aufgabe erfolgreich aktualisiert.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Aufgabe erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

public function dataTable(Request $request)
{
    $userType = auth()->user()->user_type; // Holt den 'user_type' des eingeloggten Benutzers
    $roleAndAccess = \App\Models\RoleAndAccess::where('role_name', $userType)->first();

    $canEditTask = $roleAndAccess && $roleAndAccess->can_edit_task == 'yes';
    $canDeleteTask = $roleAndAccess && $roleAndAccess->can_delete_task == 'yes';

    $task = Task::with('machine', 'priority', 'user')->get();

    return Datatables::of($task)
        ->addColumn('actions', function ($record) use ($canEditTask, $canDeleteTask) {
            $actions = '<div class="btn-list">';

            if ($canEditTask) {
                $actions .= '<a data-act="ajax-modal" data-action-url="' . route('tasks.edit', $record->id) . '" data-title="Aufgabe bearbeiten" class="btn btn-sm btn-primary">
                                <span class="fe fe-edit"> </span>
                            </a>';
            }
            
            $actions .= '<a data-act="ajax-modal"  data-action-url="' . route('tasks.show', $record->id) . '" data-title="View Task Detail" class="btn btn-sm btn-success">
                            <span class="fe fe-eye"> </span>
                        </a>';

            if ($canDeleteTask) {
                $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('tasks.destroy', $record->id) . '" data-method="get" data-table="#tasks_datatable">
                                <span class="fe fe-trash-2"> </span>
                            </button>';
            }

            $actions .= '</div>';

            return $actions;
        })
        ->addColumn('machine_id', function ($task) {
            return $task->machine->name;
        })
        ->addColumn('problem', function ($task) {
            return $task->problem;
        })
        ->addColumn('priority_id', function ($task) {
            return '<span class="badge bg-' . statusClasses($task->priority->status) . '">' . ucfirst($task->priority->status) . '</span>';
        })
        ->addColumn('username', function ($task) {
            return $task->user->username;
        })
        ->addColumn('status', function ($record) {
            return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
        })
        ->addColumn('date', function ($record) {
            return $record->created_at;
        })
        ->rawColumns(['machine_id', 'problem', 'priority_id', 'username', 'actions', 'date' , 'status'])
        ->addIndexColumn()->make(true);
}

}

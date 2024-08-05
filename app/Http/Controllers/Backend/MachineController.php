<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\MachineType;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.machine.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all(); // Hier gehen wir davon aus, dass Ihre Standorte in einem Modell namens "Location" gespeichert sind.
        $machineTypes = MachineType::all();
        return view('backend.machine.modal', [
            'machineTypes' => $machineTypes,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            $machine = Machine::create([
                'name' => $request->name,
                'machine_type_id' => $request->machine_type_id,
                'status' => $request->status,
                'location_name' => $request->location_name,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Maschine erfolgreich erstellt.',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Holen Sie auch die Standorte
        $locations = Location::all();
        $machines = Machine::findOrFail($id);
        $machineTypes = MachineType::all();
       return view('backend.machine.modal', compact('machines', 'machineTypes', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $machine = Machine::findOrFail($id);
            $machine->update([
                'name' => $request->name,
                'machine_type_id' => $request->machine_type_id,
                'status' => $request->status,
                'location_name' => $request->location_name,
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Maschine erfolgreich aktualisiert.',
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
            $machine = Machine::findOrFail($id);
            $machine->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Maschine erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   public function dataTable(Request $request)
{
    $machine = Machine::get();
    return Datatables::of($machine)
        ->addColumn('actions', function ($record) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('machines.edit', $record->id) . '" data-title="Maschine bearbeiten" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('machines.destroy', $record->id) . '" data-method="get" data-table="#machine_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            return $actions;
        })
        ->addColumn('name', function ($record) {
            return $record->name;
        })
        ->addColumn('machine_type', function ($record) {
            return $record->machineType ? $record->machineType->name : 'Kein Maschinentyp';
        })
        ->addColumn('location_name', function ($record) {
            return $record->location_name;
        })
        ->addColumn('status', function ($record) {
            return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
        })
        ->rawColumns(['actions', 'name', 'status', 'location_name']) // Fügen Sie 'location_name' zu rawColumns hinzu
        ->addIndexColumn()->make(true);
}

}

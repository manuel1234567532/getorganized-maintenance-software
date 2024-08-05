<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MachineType;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
class MachineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.machintype.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.machintype.modal');
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
            $machinetype = MachineType::create([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'MachineType erfolgreich erstellt.',
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
        $machinetype = MachineType::findOrFail($id);
        return view('backend.machintype.modal', compact('machinetype'));
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
            $machinetype = MachineType::findOrFail($id);
            $machinetype->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'MachineType erfolgreich aktualisiert.',
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
            $machinetype = MachineType::findOrFail($id);
            $machinetype->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'MachineType erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

public function dataTable(Request $request)
{
    $machinetype = MachineType::get();
    return Datatables::of($machinetype)
        ->addColumn('actions', function ($record) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('machine-types.edit', $record->id) . '" data-title="Edit MachineType" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('machine-types.destroy', $record->id) . '" data-method="get" data-table="#machine_type_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            return $actions;
        })
        ->addColumn('name', function ($record) {
            return $record->name;
        })
        ->addColumn('status', function ($record) {
            return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
        })
        ->rawColumns(['actions', 'name', 'status'])
        ->addIndexColumn()->make(true);
}

}

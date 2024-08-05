<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departement;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.departement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.departement.modal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departement_name' => 'required',

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
            $departement = Departement::create([
                'departement_name' => $request->departement_name,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Abteilung erfolgreich erstellt.',
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
    $departement = Departement::findOrFail($id);
    return view('backend.departement.modal', compact('departement'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'departement_name' => 'required',

        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $departement = Departement::findOrFail($id);
            $departement->update([
                'departement_name' => $request->departement_name,
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Standort erfolgreich aktualisiert.',
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
            $departement = Departement::findOrFail($id);
            $departement->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Abteilung erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 public function dataTable(Request $request)
{
    $departement = Departement::get();
    return Datatables::of($departement)
        ->addColumn('actions', function ($record) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('departement.edit', $record->id) . '" data-title="Abteilung bearbeiten" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('departement.destroy', $record->id) . '" data-method="get" data-table="#roles_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            return $actions;
        })
        ->addColumn('departement_name', function ($record) {
            return $record->departement_name;
        })
        ->rawColumns(['actions','name'])
        ->addIndexColumn()
        ->make(true);
}

}

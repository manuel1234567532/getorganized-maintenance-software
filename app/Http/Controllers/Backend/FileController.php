<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\Folder;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.filemanager.adminindex');
    }
    


    public function create()
    {
    
        return view('backend.filemanager.adminmodal');
    }
    
    public function show(string $id)
    {
        //
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'current_folder' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = auth()->user();
        $username = $user->username;
        $canViewDashboard = 'yes';

        try {
            DB::beginTransaction();
            $files = Files::create([
                'created_by' => $username,
                'file_name' => $request->file_name, // Verwenden Sie den Wert aus dem Request
                'current_folder' => $request->current_folder, // Verwenden Sie den Wert aus dem Request
                'created_at' => now(),
            ]);
            DB::commit();

            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Datei erfolgreich hochgeladen.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
public function dataTable(Request $request)
{
    // Abrufen der Dateieinträge aus der Tabelle "files"
    $files = Files::all();

    return Datatables::of($files) // Ändern Sie von $file auf $files
        ->addColumn('actions', function ($file) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('files.edit', $file->id) . '" data-title="Datei bearbeiten" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('files.destroy', $file->id) . '" data-method="get" data-table="#files_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            
            return $actions;
        })
        ->addColumn('file_name', function ($file) {
            return $file->file_name;
        })
        ->addColumn('file_size', function ($file) {
            return \App\Helpers\CalculateFileSize::formatSizeUnits($file->file_size);
        })
        ->addColumn('current_folder', function ($file) {
            return $file->current_folder;
        })
        ->addColumn('uploaded_by', function ($file) {
            return $file->uploaded_by;
        })
        ->addColumn('status', function ($file) {
    $status = fileStatus($file->status);
    return '<span class="badge bg-' . $status['class'] . '">' . $status['text'] . '</span>';
})
        ->rawColumns(['actions', 'file_name', 'file_size', 'current_folder', 'uploaded_by', 'status'])
        ->addIndexColumn()
        ->make(true);
}

    public function edit(string $id)
{
    $files = Files::findOrFail($id);
    $allfolders = Folder::all();
    return view('backend.filemanager.adminmodal', compact('files', 'allfolders'));
}
    
public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
         'file_name' => 'required', // angenommen, file_name enthält die neue Dateiendung
        'current_folder' => 'required',
        'uploaded_by' => 'required',
        'status' => 'required',
    ]);

    $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

    if ($validator->fails()) {
        return response()->json([
            'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $validator->errors()->first(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    try {
        $file = Files::findOrFail($id);
        $baseDirectory = 'public/files/'; // Basisverzeichnis

        // Neuen Dateipfad generieren
        $newFilePath = $baseDirectory . $request->file_name;

        // Datei im Storage umbenennen, wenn der Name geändert wurde
        if ($file->file_path != $newFilePath) {
            if (Storage::exists($file->file_path)) {
                Storage::move($file->file_path, $newFilePath);
            }
        }

        // Aktualisieren des Dateieintrags in der Datenbank
        $file->update([
            'file_name'=> $request->file_name,
            'file_path'=> $newFilePath,
            'current_folder' => $request->current_folder,
            'uploaded_by'=> $request->uploaded_by,
            'status'=> $request->status,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Datei erfolgreich aktualisiert.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    public function destroy(string $id)
{
    $file = Files::findOrFail($id);

    try {
        // Löschen der Datei aus dem Storage
        $filePath = $file->file_path; // Ersetzen Sie 'path' mit dem tatsächlichen Attributnamen, der den Dateipfad speichert
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Löschen des Eintrags aus der Datenbank
        $file->delete();

        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Datei erfolgreich gelöscht',
        ], JsonResponse::HTTP_OK);
    } catch (\Exception $exception) {
        return response()->json([
            'message' => $exception->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

}
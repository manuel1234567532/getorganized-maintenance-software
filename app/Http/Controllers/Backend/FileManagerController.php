<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Helpers\CalculateFileSize;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
         $files = Files::where('status', 'freigegeben')->get(); // Nur Dateien mit Status 'freigegeben'
      $fileSizes = Files::all('file_size'); // Holt alle Dateigrößen aus der Tabelle
    $displaySize = CalculateFileSize::calculateTotalSize($fileSizes);
     $totalBytesUsed = array_reduce($files->toArray(), function ($carry, $file) {
            return $carry + $file['file_size'];
        }, 0);

    $totalBytesMax = 128 * 1024 * 1024 * 1024; // 128 GB in Bytes
        $progressPercentage = ($totalBytesUsed / $totalBytesMax) * 100;
        $totalUsedSize = CalculateFileSize::calculateTotalSize($files);
        
        $fileCount = Files::count(); // Zählt die Anzahl der Einträge in der 'files'-Tabelle
        $folders = Folder::all(); // Alle Ordner aus der Datenbank abrufen
       $allfiles = Files::where('status', 'freigegeben')->get(); // Nur Dateien mit Status 'freigegeben'
        $filetomove = Files::all(); // oder jede andere Logik, um die zu verschiebenden Dateien zu erhalten

    	return view('backend.filemanager.index', compact('folders', 'allfiles', 'fileCount', 'displaySize', 'filetomove', 'progressPercentage', 'totalUsedSize', 'totalBytesUsed'));
    }
    
    
    public function create()
{
    return view('backend.filemanager.modal');
}

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'folder_type' => 'required',
    ]);

    $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

    if ($validator->fails()) {
        return response()->json([
            'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $validator->errors()->first(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    try {
        DB::beginTransaction();

        // Get the authenticated user (assuming you have user authentication)
        $user = auth()->user();

        // Statt der ID, speichern Sie den Benutzernamen des authentifizierten Benutzers
        $username = $user->username; // Ersetzen Sie 'username' durch den tatsächlichen Spaltennamen für den Benutzernamen in Ihrer User-Tabelle

        $folder = Folder::create([
            'folder_name' => $request->name, // Stellen Sie sicher, dass dies mit Ihrem Datenbankschema übereinstimmt
            'folder_type' => $request->folder_type,
            'created_by' => $username,
        ]);

        DB::commit();

        // Füge das JavaScript-Snippet zur Neuladung der Seite in die Antwort ein
        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Ordner erfolgreich erstellt.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}


public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'folder_type' => 'required', // Hinzufügen der Validierung für folder_type
    ]);

    $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

    if ($validator->fails()) {
        return response()->json([
            'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $validator->errors()->first(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    try {
        DB::beginTransaction();

        $folder = Folder::findOrFail($id);
        
        // Aktualisieren der Ordnerdaten
        $folder->update([
            'folder_name' => $request->name,
            'folder_type' => $request->folder_type,
            // Hier könnten Sie auch andere Felder aktualisieren, falls nötig
        ]);

        DB::commit();

        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Ordner erfolgreich aktualisiert.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
public function edit($id)
{
    $folder = Folder::findOrFail($id);
    return view('backend.filemanager.modal', compact('folder'));
}

public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:pdf'
    ]);

    $file = $request->file('file');
    $filename = $file->getClientOriginalName();
    $path = Storage::putFileAs('public/files', $file, $filename);
    $user = auth()->user();
    $username = $user->username; 

    // Dateigröße in Bytes
    $fileSize = $file->getSize();

    Files::create([
        'uploaded_by' => $username,
        'file_name' => $filename,
        'file_size' => $fileSize, // Speichern der Größe in Bytes
        'file_path' => $path,
        'current_folder' => 'none',
        'status' => 'warten_auf_freigabe',
        'created_at' => now()
    ]);
    return response()->json([
        'success' => true,
        'message' => 'Datei erfolgreich hochgeladen',
        // Weitere benötigte Daten
    ]);
}

public function viewAllFiles()
{
    // Alle Dateien abrufen
   $allfiles = Files::where('status', 'freigegeben')->get(); // Nur Dateien mit Status 'freigegeben'


    // Ansicht mit den Dateien rendern
    return view('backend.filemanager.index', compact('allfiles'));
}




public function viewFolder($folderName)
{
    // Dateien abrufen, die zum angegebenen Ordner gehören
    $files = Files::where('current_folder', $folderName)
              ->where('status', 'freigegeben')
              ->get();


    // Ansicht mit den Dateien rendern
    return view('backend.filemanager.folderView', compact('files', 'folderName'));
}


public function viewFileDetails($folderName, $fileName)
{
    $file = Files::where('file_name', $fileName)->firstOrFail();
    // Sie können zusätzliche Logik hinzufügen, um sicherzustellen, dass die Datei im angegebenen Ordner vorhanden ist.

    return view('backend.filemanager.folderViewDetails', compact('file'));
}

public function countFiles()
{
    $fileCount = Files::count(); // Zählt die Anzahl der Einträge in der 'files'-Tabelle
}
	
public function moveFileToFolder(Request $request)
{
    $fileId = $request->input('fileId');
    $folderName = $request->input('folderName');

    $file = Files::find($fileId);
    if (!$file) {
        return response()->json(['success' => false, 'errorType' => 'notFound', 'message' => 'Datei oder Ordner nicht gefunden.']);
    }

    if ($file->current_folder === $folderName) {
        return response()->json(['success' => false, 'errorType' => 'alreadyInFolder', 'message' => 'Datei ist bereits in diesem Ordner']);
    }

    $file->current_folder = $folderName;
    $file->save();

    return response()->json(['success' => true]);
}

public function redirectToFilePath($fileName)
{
    $file = Files::where('file_name', $fileName)->first();

    if ($file) {
        // Annahme: 'file_path' beinhaltet bereits den Teil 'public/files/'
        // Der Pfad sollte entsprechend konstruiert werden
        $path = '/filemanager/folder/' . $file->current_folder . '/' . $file->file_path;

        // Entfernen Sie den Teil 'public/files/', falls er im 'file_path' vorhanden ist
        $path = str_replace('public/files/', '', $path);

        return redirect($path);
    } else {
        // Datei nicht gefunden
        return back()->with('error', 'Datei nicht gefunden.');
    }
}
public function delete($fileName)
{
    $file = Files::where('file_name', $fileName)->first();
    if ($file) {
        // Pfad der Datei im Dateisystem
        $filePath = $file->file_path;

        // Datei aus dem Dateisystem löschen
        if(Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Eintrag aus der Datenbank löschen
        $file->delete();

        return response()->json(['message' => 'Datei erfolgreich gelöscht']);
    } else {
        return response()->json(['message' => 'Datei nicht gefunden'], 404);
    }
}


public function deleteByName($folderName)
{
    $folder = Folder::where('folder_name', $folderName)->first();

    if (!$folder) {
        return response()->json(['message' => 'Ordner nicht gefunden'], 404);
    }

    // Aktualisieren Sie alle Dateien, deren 'current_folder' diesem Ordner entspricht
    Files::where('current_folder', $folderName)->update(['current_folder' => 'none']);

    // Löschen Sie den Ordner aus der Datenbank
    $folder->delete();

    return response()->json(['message' => 'Ordner erfolgreich gelöscht']);
}

}
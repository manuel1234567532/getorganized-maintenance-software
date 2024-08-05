<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleAndAccess;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // dd($authUser);
        return view('backend.roles.index');
    }

    public function create()
    {
        return view('backend.roles.modal');
    }
    
    public function show(string $id)
    {
        //
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'role_color' => 'required',
            'is_deleteable' => 'required',
            'can_view_tasks' => 'required',
            'can_create_task' => 'required',
            'can_edit_task' => 'required',
            'can_delete_task' => 'required',
            'can_view_spareparts' => 'required',
            'can_create_sparepart' => 'required',
            'can_edit_sparepart' => 'required',
            'can_delete_sparepart' => 'required',
            'can_view_workorders' => 'required',
            'can_create_workorder' => 'required',
            'can_view_filemanager' => 'required',
            'can_create_folders' => 'required',
            'can_edit_folders' => 'required',
            'can_delete_folders' => 'required',
            'can_upload_files' => 'required',
            'can_move_files' => 'required',
            'can_delete_files' => 'required',
            'can_view_users' => 'required',
            'can_view_roles' => 'required',
            'can_view_categories' => 'required',
            'can_view_machines' => 'required',
            'can_view_locations' => 'required',
            'can_view_files' => 'required',
			'can_view_website_settings' => 'required',
			'can_view_website_in_maintenance_mode' => 'required',
            

        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        // dd($request->all());
        $user = auth()->user();

        // Statt der ID, speichern Sie den Benutzernamen des authentifizierten Benutzers
        $username = $user->username; // Ersetzen Sie 'username' durch den tatsächlichen Spaltennamen für den Benutzernamen in Ihrer User-Tabelle
        $canViewDashboard = 'yes'; // Den Wert auf "yes" setzen
        try {
            DB::beginTransaction();
            $roles = RoleAndAccess::create([
                'created_by' => $username,
                'role_name'=> $request->role_name,
                'role_color'=> $request->role_color,
                'can_view_dashboard' => $canViewDashboard,
                'is_deleteable'=> $request->is_deleteable,
                'can_view_tasks'=> $request->can_view_tasks,
                'can_create_task'=> $request->can_create_task,
                'can_edit_task'=> $request->can_edit_task,
                'can_delete_task'=> $request->can_delete_task,
                'can_view_spareparts'=> $request->can_view_spareparts,
                'can_create_sparepart'=> $request->can_create_sparepart,
                'can_edit_sparepart'=> $request->can_edit_sparepart,
                'can_delete_sparepart'=> $request->can_delete_sparepart,
                'can_view_workorders'=> $request->can_view_workorders,
                'can_create_workorder'=> $request->can_create_workorder,
                'can_view_filemanager'=> $request->can_view_filemanager,
                'can_create_folders'=> $request->can_create_folders,
                'can_edit_folders'=> $request->can_edit_folders,
                'can_delete_folders'=> $request->can_delete_folders,
                'can_upload_files'=> $request->can_upload_files,
                'can_move_files'=> $request->can_move_files,
                'can_delete_files'=> $request->can_delete_files,
                'can_view_users'=> $request->can_view_users,
                'can_view_roles'=> $request->can_view_roles,
                'can_view_categories'=> $request->can_view_categories,
                'can_view_machines'=> $request->can_view_machines,
                'can_view_locations'=> $request->can_view_locations,
                'can_view_files'=> $request->can_view_files,
				'can_view_website_settings'=> $request->can_view_website_settings,
				'can_view_website_in_maintenance_mode'=> $request->can_view_website_in_maintenance_mode,
                'created_at' => now(),
            ]);
            DB::commit();
            
            // Eintrag in roles Tabelle erstellen
        $role = Role::create([
            'name' => $request->role_name,
            'title' => $request->role_name,
            'guard_name' => 'web',
            'is_deleteable' => 1,
            'created_at' => now(),
        ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Rolle erfolgreich erstellt.',
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
    // Filtert die Rollen und schließt den 'Administrator' aus
    $roles = RoleAndAccess::where('role_name', '!=', 'Administrator')->get();

    return Datatables::of($roles)
        ->addColumn('actions', function ($record) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('roles.edit', $record->id) . '" data-title="Rolle bearbeiten" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('roles.destroy', $record->id) . '" data-method="get" data-table="#roles_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            
            return $actions;
        })
        ->addColumn('roles_name', function ($record) {
            return $record->roles_name;
        })
        ->rawColumns(['actions','roles_name'])
        ->addIndexColumn()
        ->make(true);
}

     public function edit(string $id)
    {
        $roles = RoleAndAccess::findOrFail($id);
        return view('backend.roles.modal', compact('roles'));
    }
    
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'role_name' => 'required',
            'role_color' => 'required',
            'is_deleteable' => 'required',
            'can_view_tasks' => 'required',
            'can_create_task' => 'required',
            'can_edit_task' => 'required',
            'can_delete_task' => 'required',
            'can_view_spareparts' => 'required',
            'can_create_sparepart' => 'required',
            'can_edit_sparepart' => 'required',
            'can_delete_sparepart' => 'required',
            'can_view_workorders' => 'required',
            'can_create_workorder' => 'required',
            'can_view_filemanager' => 'required',
            'can_create_folders' => 'required',
            'can_edit_folders' => 'required',
            'can_delete_folders' => 'required',
            'can_upload_files' => 'required',
            'can_move_files' => 'required',
            'can_delete_files' => 'required',
            'can_view_users' => 'required',
            'can_view_roles' => 'required',
            'can_view_categories' => 'required',
            'can_view_machines' => 'required',
            'can_view_locations' => 'required',
            'can_view_files' => 'required',
            'can_view_website_settings' => 'required',
			'can_view_website_in_maintenance_mode' => 'required',
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
  // dd($request->all());
        $user = auth()->user();
        $username = $user->username; // Ersetzen Sie 'username' durch den tatsächlichen Spaltennamen für den Benutzernamen in Ihrer User-Tabelle
        $canViewDashboard = 'yes'; // Den Wert auf "yes" setzen
        
        
        try {
            $roleAndAccess = RoleAndAccess::findOrFail($id);
            $oldRoleName = $roleAndAccess->role_name;

            // Aktualisieren der Rolle im Spatie Role Model zuerst
            $role = Role::where('name', $oldRoleName)->first();
            if ($role) {
                $role->name = $request->role_name;
                $role->save();
            }
            $roleAndAccess = RoleAndAccess::findOrFail($id);

            // Aktualisieren der RoleAndAccess-Tabelle
            $roleAndAccess->update([
                'created_by' => $username,
                'role_name'=> $request->role_name,
                'role_color'=> $request->role_color,
                'can_view_dashboard' => $canViewDashboard,
                'is_deleteable'=> $request->is_deleteable,
                'can_view_tasks'=> $request->can_view_tasks,
                'can_create_task'=> $request->can_create_task,
                'can_edit_task'=> $request->can_edit_task,
                'can_delete_task'=> $request->can_delete_task,
                'can_view_spareparts'=> $request->can_view_spareparts,
                'can_create_sparepart'=> $request->can_create_sparepart,
                'can_edit_sparepart'=> $request->can_edit_sparepart,
                'can_delete_sparepart'=> $request->can_delete_sparepart,
                'can_view_workorders'=> $request->can_view_workorders,
                'can_create_workorder'=> $request->can_create_workorder,
                'can_view_filemanager'=> $request->can_view_filemanager,
                'can_create_folders'=> $request->can_create_folders,
                'can_edit_folders'=> $request->can_edit_folders,
                'can_delete_folders'=> $request->can_delete_folders,
                'can_upload_files'=> $request->can_upload_files,
                'can_move_files'=> $request->can_move_files,
                'can_delete_files'=> $request->can_delete_files,
                'can_view_users'=> $request->can_view_users,
                'can_view_categories'=> $request->can_view_categories,
                'can_view_roles'=> $request->can_view_roles,
                'can_view_machines'=> $request->can_view_machines,
                'can_view_locations'=> $request->can_view_locations,
                'can_view_files'=> $request->can_view_files,
				'can_view_website_settings'=> $request->can_view_website_settings,
				'can_view_website_in_maintenance_mode'=> $request->can_view_website_in_maintenance_mode,				
                'updated_at' => now(),
            ]);
            
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Rolle erfolgreich aktualisiert.',
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
        $roleAndAccess = RoleAndAccess::findOrFail($id);
        $roleName = $roleAndAccess->role_name;

        // Überprüfen, ob die Rolle in der 'users' Tabelle verwendet wird
        $roleInUse = DB::table('users')->where('user_type', $roleName)->exists();

        if ($roleInUse) {
            // Wenn die Rolle verwendet wird, senden Sie eine Fehlermeldung
            return response()->json([
                'message' => 'Die Rolle ist in Verwendung und kann somit nicht gelöscht werden!',
            ], JsonResponse::HTTP_CONFLICT);
        }

        try {
            // Löschen der Rolle aus der RoleAndAccess-Tabelle
            $roleAndAccess->delete();

            // Finden und Löschen der Rolle aus der Spatie Role-Tabelle
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Rolle erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
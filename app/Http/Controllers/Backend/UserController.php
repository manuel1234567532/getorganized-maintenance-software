<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $departments = Departement::all();
        
        return view('backend.users.modal', compact('departments')); // Hier wird modal2.blade.php anstelle von modal.blade.php verwendet
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'first_name' => 'string|max:255',
        'last_name' => 'string|max:255',
        'birthday' => [
            'nullable',
            'date_format:d.m.Y', // Im deutschen Format
        ],
        'department' => 'string|max:255',
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
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => $request->role,
                'status' => $request->status,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday ? \Carbon\Carbon::createFromFormat('d.m.Y', $request->birthday)->format('Y-m-d') : null,
                'department' => $request->department,
            ]);
            $user->assignRole($request->input('role'));

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Benutzer erfolgreich erstellt.',
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
    $departments = Departement::all();
    $user = User::findOrFail($id);
    return view('backend.users.modal', compact('user', 'departments')); // Hier wird modal2.blade.php anstelle von modal.blade.php verwendet
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $id,
            ],
            'email' => [
            'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $id,
            ],
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
            ],
            'first_name' => [
            'string',
            'max:255',
            ],
            'last_name' => [
            'string',
            'max:255',
            ],
            'birthday' => [
            'nullable',
            'date_format:d.m.Y', // Im deutschen Format
            ],
            'department' => [
            'string',
            'max:255',
        ],
        ]);

        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = User::findOrFail($id);
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => $request->role,
                'status' => $request->status,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday ? \Carbon\Carbon::createFromFormat('d.m.Y', $request->birthday)->format('Y-m-d') : null,
                'department' => $request->department,
            ]);
            $user->assignRole($request->input('role'));

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Benutzer erfolgreich aktualisiert.',
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
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Benutzer erfolgreich gelöscht',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

 public function dataTable(Request $request)
{
    $users = User::where('user_type', '!=', 'Administrator')
        ->orderBy('id', 'desc')
        ->get();
    return Datatables::of($users)
        ->addColumn('actions', function ($record) {
            $actions = '<div class="btn-list">';
            $actions .= '<a data-act="ajax-modal" data-action-url="' . route('users.edit', $record->id) . '" data-title="Benutzer bearbeiten" class="btn btn-sm btn-primary">
                            <span class="fe fe-edit"> </span>
                        </a>';
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('users.destroy', $record->id) . '" data-method="get" data-table="#users_datatable">
                            <span class="fe fe-trash-2"> </span>
                        </button>';
            $actions .= '</div>';
            return $actions;
        })
        ->addColumn('name', function ($record) {
            $route = route('users.edit', $record->id);
            return '<a href="javascript:void(0)" data-act="ajax-modal" data-action-url="' . $route . '" class="link" data-toggle="tooltip" data-placement="top" data-title="Edit User">' . getFullName($record) . '</a>';
        })
        ->addColumn('email', function ($record) {
            return $record->email;
        })
        ->addColumn('first_name', function ($record) {
            return $record->first_name;
        })
        ->addColumn('last__name', function ($record) {
            return $record->last__name;
        })
        ->addColumn('birthday', function ($record) {
            return $record->birthday;
        })
        ->addColumn('department', function ($record) {
            return $record->department;
        })
        ->addColumn('user_type', function ($record) {
            return $record->user_type;
        })
        ->addColumn('status', function ($record) {
            return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
        })
        ->rawColumns(['actions', 'email', 'name', 'first_name', 'last__name', 'birthday', 'departement','status', 'user_type'])
        ->addIndexColumn()->make(true);
}

    public function ShowPasswordForm()
    {
        // dd($authUser);
        return view('backend.users.updatepassword');
    }

    public function Updateuserpassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $validator->setCustomMessages(include base_path('resources/lang/de/messages.php'));

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $profile = User::findOrFail($id);

            if (!Hash::check($request->current_password, $profile->password)) {
                return response()->json([
                    'status' => JsonResponse::HTTP_UNAUTHORIZED,
                    'message' => 'Current password not matched.',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }

            $profile->update([
                'password' => Hash::make($request->password),
                'update_password' => '1',
            ]);

            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Password changed successfully.',
                'redirectUrl' => route('dashboard'),
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
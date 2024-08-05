<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
         $user = Auth::user();

    // Initialisieren der Variable $recoveryCodes
    $recoveryCodes = [];

  // Prüfen, ob 2FA aktiviert ist
if ($user->two_factor_confirmed_at == "0000-00-00 00:00:00") {
    $user->two_factor_confirmed_at = false;
} elseif ($user->two_factor_confirmed_at) {
    // Entschlüsseln Sie die Wiederherstellungscodes
    $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
}


    return view('backend.profile.edit', ['recoveryCodes' => $recoveryCodes]);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
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
        DB::beginTransaction();
        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = saveResizeImage($request->image, 'Image', 1024, 'jpg');
            $user->update(['avatar' => $imageName]);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday ? \Carbon\Carbon::createFromFormat('d.m.Y', $request->birthday)->format('Y-m-d') : null,
            'department' => $request->department,
        ]);

        DB::commit();
        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Profil erfolgreich aktualisiert.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    public function changePassword(Request $request, $id)
    {
         $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
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
                    'message' => 'Aktuelles Passwort stimmt nicht überein.',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }

            $profile->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Passwort erfolgreich geändert',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePicture()
    {

    }


}

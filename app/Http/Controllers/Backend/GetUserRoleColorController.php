<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleAndAccess;

class GetUserRoleColorController extends Controller
{
    public function getUserRoleColor(Request $request)
    {
        // Annahme: Du hast bereits den Benutzer und seinen user_type abgerufen.
        $userType = auth()->user()->user_type;

        // Suche in der roles_and_access-Tabelle nach dem role_name basierend auf user_type.
        $roleAccess = RoleAndAccess::where('role_name', $userType)->first();

        if ($roleAccess) {
            // Wenn eine Rolle gefunden wurde, hol den Farbcode (Hex-Code) aus der role_color-Spalte.
            $userRoleColor = $roleAccess->role_color;
        } else {
            // Wenn keine passende Rolle gefunden wurde, kannst du eine Standardfarbe verwenden oder eine Fehlerbehandlung durchführen.
            $userRoleColor = '#000000'; // Standardfarbe
        }

        return view('user_role_color', ['userRoleColor' => $userRoleColor]);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\WebsiteSettings;
use App\Models\RoleAndAccess; // Importieren Sie das RolesAndAccess Model

class CheckMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        // Holen Sie den Wert des 'maintenance_mode' direkt
        $maintenanceMode = WebsiteSettings::first()->maintenance_mode;

        // Überprüfen, ob der Wartungsmodus aktiviert ist
        if ($maintenanceMode === 'yes') {
            // Überprüfen, ob der Benutzer eingeloggt ist
            if (!auth()->check()) {
                return redirect()->route('maintenance');
            }

            // Holen Sie den user_type des eingeloggten Benutzers
            $userType = auth()->user()->user_type;

            // Überprüfen Sie, ob dieser user_type (als role_name) in roles_and_access den Zugriff im Wartungsmodus hat
            $accessAllowed = RoleAndAccess::where('role_name', $userType)
                                            ->where('can_view_website_in_maintenance_mode', 'yes')
                                            ->exists();

            // Wenn der Benutzer keinen Zugriff hat, leiten Sie ihn zur Wartungsseite um
            if (!$accessAllowed) {
                return redirect()->route('maintenance');
            }
        } else {
            // Wenn der Wartungsmodus deaktiviert ist, verhindern Sie den Zugriff auf die Wartungsseite
            if ($request->is('maintenance')) {
                return redirect()->route('dashboard'); // oder eine andere geeignete Route
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleAccess
{
   public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $roleName = $user->user_type; // Annahme, dass der Rollenname in user_type gespeichert ist
        $roleAccess = \App\Models\RoleAndAccess::where('role_name', $roleName)->first();

        if (!$roleAccess) {
            return redirect('/dashboard'); // Keine Rolle gefunden
        }

        $routeName = $request->route()->getName();
        $accessMap = [
            'dashboard' => 'can_view_dashboard',
            'tasks.index' => 'can_view_tasks',
            'spareparts.index' => 'can_view_spareparts',
            'work-order.index' => 'can_view_workorders',
            'filemanager.index' => 'can_view_filemanager',
            'users.index' => 'can_view_users',
            'roles.index' => 'can_view_roles',
            'machine-types.index' => 'can_view_categories',
            'machines.index' => 'can_view_machines',
            'location.index' => 'can_view_locations',
            'files.index' => 'can_view_files',
            'departement.index' => 'can_view_departement',
			'general-settings.index' => 'can_view_website_settings',
        ];

        $accessField = $accessMap[$routeName] ?? null;
        if ($accessField && $roleAccess->$accessField === 'no') {
            return redirect('/dashboard'); // Zugriff verweigert
        }

        return $next($request);
    }
}
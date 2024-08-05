<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;



use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

       // Überprüfen Sie, ob der Benutzer 2FA aktiviert hat und two_factor_confirmed_at gesetzt ist
    if ($user && $user->two_factor_secret && $user->two_factor_confirmed_at) {
        // Wenn ja, überprüfen Sie, ob die 2FA bereits erfolgreich bestanden wurde
        if (!$request->session()->has('2fa_passed')) {
            Auth::logout();
            return redirect()->route('login');
        }
    }

        return $next($request);
    }
}
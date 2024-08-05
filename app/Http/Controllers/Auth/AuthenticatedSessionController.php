<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = $request->user();
        if ($user->update_password === '0') {
              return redirect()->route('users-password-update');

        }
  // Überprüfe, ob der Benutzer die 2FA aktiviert hat und two_factor_confirmed_at gesetzt ist
   if ($user->two_factor_secret && $user->two_factor_confirmed_at !== null) {
        $request->session()->put('2fa:user:id', $user->id);
        // Benutzer hat 2FA aktiviert und bestätigt, leite zur 2FA-Überprüfung weiter
        return redirect()->route('two-factor.login');
    }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

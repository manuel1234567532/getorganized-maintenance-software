<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
 
class TwoFactorController extends Controller
{
    
    
    public function activate2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();
        $user->two_factor_secret = $google2fa->generateSecretKey();
        $user->save();

        $qrCodeUrl = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->username,
            $user->two_factor_secret
        );
// QR-Code und Wiederherstellungscodes senden
    return response()->json([
        'qrCodeUrl' => $qrCodeUrl,
    ]);

    }

public function verify2fa(Request $request)
    {
        $request->validate(['verification_code' => 'required']);

        $user = Auth::user();
        $google2fa = new Google2FA();
         $recoveryCodes = collect(range(1, 8))->map(function () {
        return rand(100000, 999999);
    })->toArray();

        // Versuche, den regulären 2FA-Code zu verifizieren
        if ($google2fa->verifyKey($user->two_factor_secret, $request->verification_code)) {
            // Der reguläre 2FA-Code ist korrekt
            $user->two_factor_confirmed_at = now();
           $user->two_factor_recovery_codes = encrypt(json_encode(collect($recoveryCodes)->map(function ($code) {
        return Hash::make($code);
    })->toArray()));
        $user->save();

            return response()->json([
             'recoveryCodes' => $recoveryCodes, // Senden Sie die unverschlüsselten Codes,
            'success' => true,
            'message' => '2FA erfolgreich verifiziert.'
        ]);
    }
}

 public function deactivate2fa(Request $request)
    {
        $user = Auth::user();

        // Überprüfen, ob der Benutzer bereits 2FA aktiviert hat
        if (!$user->two_factor_confirmed_at) {
            return back()->with('error', '2FA ist nicht aktiviert.');
        }

        // Deaktiviere 2FA
        $user->two_factor_secret = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return back()->with('success', '2FA wurde erfolgreich deaktiviert.');
    }
 public function store(Request $request)
    {
        $request->validate(['code' => 'required']);

        $user = Auth::user();

        // Überprüfung des 2FA-Codes
        if ($user->two_factor_secret && $user->validateTwoFactorCode($request->code)) {
            // 2FA-Code ist korrekt, leiten Sie den Benutzer weiter
            return redirect()->intended('dashboard');
        }

        // 2FA-Code ist nicht korrekt, senden Sie eine Fehlermeldung zurück
        return back()->withErrors(['code' => 'Der bereitgestellte 2FA-Code ist nicht korrekt.']);
    }
     public function show2faform(Request $request)
    {
        if ($request->session()->get('2fa_passed', false)) {
        // Wenn 2fa_passed bereits gesetzt ist, leite den Benutzer um
        return redirect()->intended('dashboard');
    }
          return view('auth.two-factor-challenge');
    }
    
    
    public function verify2faLogin(Request $request)
{
    $request->validate(['2fa_token' => 'required']);

    $userId = session('2fa:user:id');
    if (!$userId) {
        // Anstatt eine Weiterleitung, sende eine JSON-Antwort
         return response()->json([
        'success' => false,
        'message' => 'Ungültige Anfrage.'
    ], 400);
    }

    $user = User::findOrFail($userId);
    $google2fa = new Google2FA();

    if ($google2fa->verifyKey($user->two_factor_secret, $request->input('2fa_token'))) {
        // 2FA Code ist korrekt
         $request->session()->put('2fa_passed', true);
        $this->loginUser($request, $user);
        return response()->json(['success' => true]);
    } else {
        if ($this->checkRecoveryCode($user, $request->input('2fa_token'))) {
            // Wiederherstellungscode ist korrekt
             $request->session()->put('2fa_passed', true);
            $this->loginUser($request, $user);
           return response()->json([
    'success' => true,
    'message' => '2FA bestanden!'
]);
        } else {
             return response()->json([
    'success' => false,
    'message' => 'Falscher 2FA-Code oder Wiederherstellungscode!'
]);
        }
    }
}


private function checkRecoveryCode($user, $code)
{
    $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

    foreach ($recoveryCodes as $recoveryCode) {
        if (Hash::check($code, $recoveryCode)) {
            // Code ist korrekt
            // Entferne den verwendeten Wiederherstellungscode
            $remainingCodes = array_diff($recoveryCodes, [$recoveryCode]);
            $user->two_factor_recovery_codes = encrypt(json_encode($remainingCodes));
            $user->save();

            return true;
        }
    }

    return false;
}
private function loginUser(Request $request, $user)
{
    Auth::login($user);
    $request->session()->forget('2fa:user:id');

    // Hier könntest du zusätzliche Logik hinzufügen, falls benötigt
}

}
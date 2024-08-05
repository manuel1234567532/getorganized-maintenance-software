<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View; // Fügen Sie diese Zeile hinzu

class CheckForTwoFactorController extends Controller
{
    public function create(): View // Jetzt korrekt referenziert
    {
        return view('auth.two-factor-challenge');
    }
}

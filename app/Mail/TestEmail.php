<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

   public function build()
{
    // Den aktuellen Benutzer abrufen
    $user = Auth::user();

    return $this->subject('GetOrganized.at - Test E-Mail erfolgreich!')
                ->html('Hallo ' . $user->first_name . ', <br> 
                       diese Email ist ein gutes Zeichen! Sie sagt dir, dass deine SMTP Konfiguration erfolgreich war! <br> 
                       ' . config('app.name'));
}
}

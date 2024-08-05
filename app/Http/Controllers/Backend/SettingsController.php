<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB; // Korrekter Import für die DB-Fassade
use Illuminate\Http\Request;
use App\Models\WebsiteSettings;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($authUser);
        return view('backend.settings.index');
    }
		
     public function settings()
    {
          $settings = WebsiteSettings::first();
          $maintenanceMode = $settings->maintenance_mode;
        // dd($authUser);
        return view('backend.settings.generalsettings', compact('settings', 'maintenanceMode'));
    }
    
 public function notification()
{
    $settings = WebsiteSettings::first();
    
    $notificationSettings = [
        'account_created_mail' => $settings->account_created_mail,
        'account_created_welcome_mail' => $settings->account_created_welcome_mail,
        'account_blocked_mail' => $settings->account_blocked_mail,
        'account_unlocked_mail' => $settings->account_unlocked_mail,
        'workorder_overdue_mail' => $settings->workorder_overdue_mail,
        'workorder_completed_mail' => $settings->workorder_completed_mail,
        'file_accepted_mail' => $settings->file_accepted_mail,
        'file_notaccepted_mail' => $settings->file_notaccepted_mail,
    ];

    return view('backend.settings.notificationsettings', compact('notificationSettings'));
}
	
public function smtpsettings()
{
    $settings = WebsiteSettings::first(); // Erste Reihe der Einstellungen abrufen

    // Überprüfen, ob smtp_settings_saved 'yes' ist
    $isSmtpSettingsSaved = $settings && $settings->smtp_settings_saved === 'yes';

    return view('backend.settings.smtpsettings', [
        'settings' => $settings,
        'isSmtpSettingsSaved' => $isSmtpSettingsSaved
    ]);
}

    
     public function maintenancemode()
    {
        return view('backend.maintenancemode.maintenance');
    }
    
public function updateSettings(Request $request)
{
    DB::beginTransaction();

    try {
        $settings = WebsiteSettings::first();
        $websiteName = $request->input('websiteName');

        if (empty($websiteName)) {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Webseitename darf nicht leer sein.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $settings->website_name = $websiteName;
        $settings->save();

        DB::commit();

        return response()->json([
            'success' => JsonResponse::HTTP_OK,
            'message' => 'Einstellungen erfolgreich gespeichert.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
	
	public function uploadLogo(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'png') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 300 && $height <= 300) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'logo-login.png';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->website_logo = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Logo erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Bild darf nicht größer als 300x100px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Bild muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Bild zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
	
	public function uploadIcon(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'ico') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 16 && $height <= 16) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'icon.ico';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->website_icon = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Icon erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Icon darf nicht größer als 512x512px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Icon muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Icon zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function uploadlogosidebaropenwhite(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('sidebaropenwhite')) {
            $file = $request->file('sidebaropenwhite');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'png') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 512 && $height <= 512) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'sidebar_open_white.png';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->sidebar_open_white = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Icon erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Icon darf nicht größer als 512x512px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Icon muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Icon zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function uploadlogosidebaropendark(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('sidebaropendark')) {
            $file = $request->file('sidebaropendark');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'png') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 512 && $height <= 512) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'sidebar_open_dark.png';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->sidebar_open_black = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Icon erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Icon darf nicht größer als 512x512px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Icon muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Icon zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function uploadlogosidebarclosedwhite(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('sidebarclosedwhite')) {
            $file = $request->file('sidebarclosedwhite');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'png') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 512 && $height <= 512) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'sidebar_closed_white.png';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->sidebar_minimized_white = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Icon erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Icon darf nicht größer als 512x512px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Icon muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Icon zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function uploadlogosidebarcloseddark(Request $request)
{
    try {
        // Überprüfen, ob ein Bild hochgeladen wurde
        if ($request->hasFile('sidebarcloseddark')) {
            $file = $request->file('sidebarcloseddark');

            // Überprüfen, ob das Bild ein .png ist
            if ($file->getClientOriginalExtension() == 'png') {
                // Überprüfen, ob das Bild nicht größer als 300x100px ist
                list($width, $height) = getimagesize($file);
                if ($width <= 512 && $height <= 512) {
                    // Generiere einen eindeutigen Dateinamen
                    $filename = 'sidebar_closed_dark.png';

                    // Speichere das Logo mit Storage::putFileAs
                    $path = Storage::putFileAs('public/websiteSettings', $file, $filename);

                    // Aktualisiere den Pfad in der Datenbank
                    $settings = WebsiteSettings::first();
                    $settings->sidebar_minimized_black = $path;
                    $settings->save();

                    return response()->json([
                        'success' => JsonResponse::HTTP_OK,
                        'message' => 'Icon erfolgreich hochgeladen und gespeichert.',
                    ], JsonResponse::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => JsonResponse::HTTP_BAD_REQUEST,
                        'message' => 'Das Icon darf nicht größer als 512x512px sein.',
                    ], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => JsonResponse::HTTP_BAD_REQUEST,
                    'message' => 'Das hochgeladene Icon muss im PNG-Format sein.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'message' => 'Es wurde kein Icon zum Hochladen ausgewählt.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function restore()
    {
        // Definieren Sie die Pfade
       $settingsPath = storage_path('app/public/websiteSettings');
        // Pfad zum Backup-Ordner
        $backupPath = storage_path('app/public/websiteSettings/websiteSettingsBackup');

        // Löschen Sie alle .png und .ico Dateien aus websiteSettings
        $files = File::glob($settingsPath . '/*.{png,ico}', GLOB_BRACE);
        foreach ($files as $file) {
            File::delete($file);
        }

        // Kopieren Sie alle Dateien aus dem Backup-Ordner
        $backupFiles = File::allFiles($backupPath);
        foreach ($backupFiles as $file) {
            $destination = $settingsPath . '/' . $file->getFilename();
            File::copy($file->getPathname(), $destination);
        }

        // Senden Sie eine Erfolgsmeldung zurück
        return response()->json(['message' => 'Backup erfolgreich wiederhergestellt!'], 200);
    }
    
public function updateMaintenanceMode(Request $request)
{
    try {
        $maintenanceMode = $request->input('maintenance_mode');

        // Stellen Sie sicher, dass $maintenanceMode auf 'yes' oder 'no' gesetzt ist
        if ($maintenanceMode !== 'yes' && $maintenanceMode !== 'no') {
            return response()->json(['message' => 'Ungültiger Wert für maintenance_mode.'], 400);
        }

        $settings = WebsiteSettings::first();
        $settings->maintenance_mode = $maintenanceMode;
        $settings->save();

        return response()->json([
            'success' => true, // Setzen Sie 'success' auf true für erfolgreiche Aktionen
            'message' => 'Wartungsmodus wurde erfolgreich aktualisiert.'
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false, // Setzen Sie 'success' auf false im Fehlerfall
            'message' => $e->getMessage()
        ], 500);
    }
}

	public function updateNotifications(Request $request)
{
    try {
        // Deine Aktionslogik hier...
        // Erhalte die Daten aus dem Ajax-Request
        $accountCreatedMail = $request->input('account_created_mail');
        $welcomeMail = $request->input('account_created_welcome_mail');
        $accountBlockedMail = $request->input('account_blocked_mail');
        $accountUnblockedMail = $request->input('account_unlocked_mail');
        $workOrderOverdueMail = $request->input('workorder_overdue_mail');
        $workOrderCompletedMail = $request->input('workorder_completed_mail');
        $fileAcceptedMail = $request->input('file_accepted_mail');
        $fileNotAcceptedMail = $request->input('file_notaccepted_mail');

        // Aktualisiere die Benachrichtigungseinstellungen in der Datenbank
        $settings = WebsiteSettings::first();

        $settings->account_created_mail = $accountCreatedMail;
        $settings->account_created_welcome_mail = $welcomeMail;
        $settings->account_blocked_mail = $accountBlockedMail;
        $settings->account_unlocked_mail = $accountUnblockedMail;
        $settings->workorder_overdue_mail = $workOrderOverdueMail;
        $settings->workorder_completed_mail = $workOrderCompletedMail;
        $settings->file_accepted_mail = $fileAcceptedMail;
        $settings->file_notaccepted_mail = $fileNotAcceptedMail;

        $settings->save();

        return response()->json([
            'status' => JsonResponse::HTTP_OK,
            'message' => 'Einstellungen erfolgreich gespeichert.',
        ], JsonResponse::HTTP_OK);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
public function updatesmtpsettings(Request $request)
{
    try {
        DB::beginTransaction();

        $validatedData = $request->validate([
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|numeric',
            'smtp_password' => 'required|string',
            'smtp_username' => 'required|string',
            'smtp_security' => 'required|string',
        ]);

        $settings = WebsiteSettings::first();

        if (!$settings) {
            return response()->json([
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'message' => 'Einstellungen nicht gefunden',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Setzen Sie den Wert der Spalte 'smtp_settings_saved' auf "yes"
        $validatedData['smtp_settings_saved'] = 'yes';

        $settings->update($validatedData);

        DB::commit();

        return response()->json([
            'status' => JsonResponse::HTTP_OK,
            'message' => 'SMTP-Einstellungen erfolgreich gespeichert.',
        ], JsonResponse::HTTP_OK);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}


public function sendTestEmail(Request $request)
{
    try {
        // SMTP-Konfiguration aus der Datenbank abrufen
        $smtpSettings = DB::table('website_settings')
            ->select('smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_security')
            ->first();

        if ($smtpSettings) {
            // SMTP-Konfiguration setzen
            Config::set('mail.mailers.smtp.host', $smtpSettings->smtp_host);
            Config::set('mail.mailers.smtp.port', $smtpSettings->smtp_port);
            Config::set('mail.mailers.smtp.username', $smtpSettings->smtp_username);
            Config::set('mail.mailers.smtp.password', $smtpSettings->smtp_password);

            // Überprüfen und setzen Sie die Verschlüsselungseinstellungen basierend auf "smtp_security"
            $smtpSecurity = $smtpSettings->smtp_security;
            if ($smtpSecurity === 'tls') {
                Config::set('mail.mailers.smtp.encryption', 'tls');
            } elseif ($smtpSecurity === 'ssl') {
                Config::set('mail.mailers.smtp.encryption', 'ssl');
            }
        } else {
            // Keine SMTP-Einstellungen gefunden
            return response()->json([
                'status' => 'error',
                'message' => 'Keine SMTP-Einstellungen gefunden.',
            ]);
        }

        // Benutzerinformationen abrufen und Test-E-Mail senden
        $user = Auth::user();
        Mail::mailer('smtp')->to($user->email)->send(new TestEmail($user->name));
        
        DB::table('website_settings')
            ->update(['test_mail_send' => 'yes']);
            
        return response()->json([
            'status' => 'success',
            'message' => 'E-Mail erfolgreich versendet.',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Fehler beim Senden der E-Mail: ' . $e->getMessage(),
        ]);
    }
}

	}
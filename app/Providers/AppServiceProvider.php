<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\WebsiteSettings;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
   // Überprüfen, ob die Tabelle 'website_settings' existiert
    if (Schema::hasTable('website_settings')) {
        // Abrufen des Website-Namens aus der Datenbank, wenn die Tabelle existiert
        $appName = WebsiteSettings::first()->website_name ?? 'GetOrganized.at';
    } else {
        // Standardwert setzen, wenn die Tabelle nicht existiert
        $appName = 'GetOrganized.at';
    }

    // Setzen des Anwendungsnamens
    Config::set('app.name', $appName);
}
	
}

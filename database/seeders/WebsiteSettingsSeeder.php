<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WebsiteSettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('website_settings')->insert([
            'website_name' => 'GetOrganized.at',
            'website_logo' => 'public/websiteSettings/websiteSettingsBackup/logo-login.png',
            'website_icon' => 'public/websiteSettings/websiteSettingsBackup/',
            'sidebar_open_white' => 'public/websiteSettings/websiteSettingsBackup/sidebar_open_white.png',
            'sidebar_open_black' => 'public/websiteSettings/websiteSettingsBackup/sidebar_open_dark.png',
            'sidebar_minimized_white' => 'public/websiteSettings/websiteSettingsBackup/sidebar_closed_white.png',
            'sidebar_minimized_black' => 'public/websiteSettings/websiteSettingsBackup/sidebar_closed_dark.png',
            'maintenance_mode' => 'no',
			'account_created_mail' => 'yes',
			'account_created_welcome_mail' => 'yes',
			'account_blocked_mail' => 'yes',
			'account_unlocked_mail' => 'yes',
			'workorder_overdue_mail' => 'yes',
			'workorder_completed_mail' => 'yes',
			'file_accepted_mail' => 'yes',
			'file_notaccepted_mail' => 'yes',
			'smtp_host' => '',
			'smtp_port' => '465',
			'smtp_username' => '',
			'smtp_password' => '',
			'smtp_security' => 'ssl',
			'smtp_settings_saved' => 'no',
			'test_mail_send' => 'no',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
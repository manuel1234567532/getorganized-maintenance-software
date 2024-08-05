<?php

namespace Database\Seeders;

use App\Models\RoleAndAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleAndAccess::create([
            'created_by' => 'Administrator',
            'role_name' => 'Administrator',
            'role_color' => '#ff0033',
            'guard_name' => 'web',
            'can_view_dashboard' => 'yes',
            'can_view_tasks' => 'yes',
            'can_view_spareparts' => 'yes',
            'can_view_workorders' => 'yes',
            'can_view_filemanager' => 'yes',
            'can_view_users' => 'yes',
            'can_view_roles' => 'yes',
            'can_view_categories' => 'yes',
            'can_view_machines' => 'yes',
            'can_view_locations' => 'yes',
            'can_view_files' => 'yes',
            'can_view_departement' => 'yes',
			'can_view_website_settings' => 'yes',
            'can_create_task' => 'yes',
            'can_edit_task' => 'yes',
            'can_delete_task' => 'yes',
            'can_create_sparepart' => 'yes',
            'can_edit_sparepart' => 'yes',
            'can_delete_sparepart' => 'yes',
            'can_create_workorder' => 'yes',
            'can_create_folders' => 'yes',
            'can_edit_folders' => 'yes',
            'can_delete_folders' => 'yes',
            'can_upload_files' => 'yes',
            'can_move_files' => 'yes',
            'can_delete_files' => 'yes',
			'can_view_website_in_maintenance_mode' => 'yes',
            'is_deleteable' => 'no',
            'created_at' => now(),

        ]);
    }
}

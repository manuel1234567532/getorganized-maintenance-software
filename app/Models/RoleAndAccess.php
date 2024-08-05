<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAndAccess extends Model
{
    use HasFactory;
    protected $table = 'roles_and_access';

    protected $fillable = [
        'created_by', 'role_name', 'role_color', 'guard_name',
        'can_view_dashboard', 'can_view_tasks','can_view_spareparts', 'can_view_workorders',
        'can_view_filemanager','can_view_users', 'can_view_roles', 'can_view_categories', 'can_view_machines',
        'can_view_locations', 'can_view_files', 'can_view_website_settings', 'can_create_task', 'can_edit_task', 'can_delete_task',
        'can_create_sparepart', 'can_edit_sparepart', 'can_delete_sparepart', 'can_view_website_in_maintenance_mode',
        'can_create_workorder', 'can_edit_folders', 'can_create_folders', 'can_delete_folders', 'can_upload_files', 'can_move_files', 'can_delete_files', 'is_deleteable',
    ];

    // Optionally, if you want to work with dates
    protected $dates = ['created_at', 'updated_at'];
}

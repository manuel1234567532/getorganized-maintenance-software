<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles_and_access', function (Blueprint $table) {
            $table->id();
            $table->string('created_by');
            $table->string('role_name');
            $table->string('role_color');
            $table->string('guard_name')->default('web');
            $table->enum('can_view_dashboard', ['yes', 'no'])->default('no');
            $table->enum('can_view_tasks', ['yes', 'no'])->default('no');
            $table->enum('can_view_spareparts', ['yes', 'no'])->default('no');
            $table->enum('can_view_workorders', ['yes', 'no'])->default('no');
            $table->enum('can_view_filemanager', ['yes', 'no'])->default('no');
            $table->enum('can_view_users', ['yes', 'no'])->default('no');
            $table->enum('can_view_roles', ['yes', 'no'])->default('no');
            $table->enum('can_view_categories', ['yes', 'no'])->default('no');
            $table->enum('can_view_machines', ['yes', 'no'])->default('no');
            $table->enum('can_view_locations', ['yes', 'no'])->default('no');
            $table->enum('can_view_files', ['yes', 'no'])->default('no');
            $table->enum('can_view_departement', ['yes', 'no'])->default('no');
			$table->enum('can_view_website_settings', ['yes', 'no'])->default('no');
            $table->enum('can_create_task', ['yes', 'no'])->default('no');
            $table->enum('can_edit_task', ['yes', 'no'])->default('no');
            $table->enum('can_delete_task', ['yes', 'no'])->default('no');
            $table->enum('can_create_sparepart', ['yes', 'no'])->default('no');
            $table->enum('can_edit_sparepart', ['yes', 'no'])->default('no');
            $table->enum('can_delete_sparepart', ['yes', 'no'])->default('no');
            $table->enum('can_create_workorder', ['yes', 'no'])->default('no');
            $table->enum('can_create_folders', ['yes', 'no'])->default('no');
            $table->enum('can_edit_folders', ['yes', 'no'])->default('no');
            $table->enum('can_delete_folders', ['yes', 'no'])->default('no');
            $table->enum('can_upload_files', ['yes', 'no'])->default('no');
            $table->enum('can_move_files', ['yes', 'no'])->default('no');
            $table->enum('can_delete_files', ['yes', 'no'])->default('no');
			$table->enum('can_view_website_in_maintenance_mode', ['yes', 'no'])->default('no');
            $table->enum('is_deleteable', ['yes', 'no'])->default('no');
            // ... Add other fields as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_and_access');
    }
};
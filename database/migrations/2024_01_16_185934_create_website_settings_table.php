<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name');
            $table->string('website_logo');
            $table->string('website_icon');
            $table->string('sidebar_open_white');
            $table->string('sidebar_open_black');
            $table->string('sidebar_minimized_white');
            $table->string('sidebar_minimized_black');
            $table->enum('maintenance_mode', ['yes', 'no'])->default('no');
			$table->enum('account_created_mail', ['yes', 'no'])->default('no');
			$table->enum('account_created_welcome_mail', ['yes', 'no'])->default('no');
			$table->enum('account_blocked_mail', ['yes', 'no'])->default('no');
			$table->enum('account_unlocked_mail', ['yes', 'no'])->default('no');
			$table->enum('workorder_overdue_mail', ['yes', 'no'])->default('no');
			$table->enum('workorder_completed_mail', ['yes', 'no'])->default('no');
			$table->enum('file_accepted_mail', ['yes', 'no'])->default('no');
			$table->enum('file_notaccepted_mail', ['yes', 'no'])->default('no');
			$table->string('smtp_host');
            $table->string('smtp_port');
            $table->string('smtp_username');
            $table->string('smtp_password');
            $table->string('test_email_set');
			$table->enum('smtp_security', ['ssl', 'tls'])->default('ssl');
			$table->enum('smtp_settings_saved', ['yes', 'no'])->default('no');
			$table->enum('test_mail_send', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('website_settings');
    }
};
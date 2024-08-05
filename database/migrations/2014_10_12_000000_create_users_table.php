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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('first_name')->nullable(); // Hinzugefügt
            $table->string('last_name')->nullable();  // Hinzugefügt
            $table->date('birthday')->nullable();      // Hinzugefügt
            $table->string('department')->nullable();  // Hinzugefügt
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('two_factor_secret')->nullable(); 
            $table->string('two_factor_recovery_codes')->nullable(); 
            $table->string('two_factor_confirmed_at')->nullable(); 
            $table->enum('update_password', ['0', '1'])->default('0');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_type');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

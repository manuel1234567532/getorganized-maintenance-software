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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
              $table->string('folder_name', 255); // varchar(255)
            $table->enum('folder_type', ['pdf blau', 'pdf gelb', 'video blau', 'video gelb']); // enum
            $table->string('created_by', 255); // varchar(255), falls es sich um einen String handelt
            $table->timestamps(); // Erstellt die Spalten created_at und updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
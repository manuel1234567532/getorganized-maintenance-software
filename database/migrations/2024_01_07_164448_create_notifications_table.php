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
       Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('created_for'); // Für den Benutzernamen
            $table->timestamp('created_date')->useCurrent(); // Datum der Erstellung
            $table->text('message'); // Nachrichteninhalt
            $table->enum('status', ['read', 'not read'])->default('not read'); // Status der Nachricht
           $table->text('type'); // Nachrichteninhalt
            $table->timestamps(); // Erstellt automatisch 'created_at' und 'updated_at' Spalten
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
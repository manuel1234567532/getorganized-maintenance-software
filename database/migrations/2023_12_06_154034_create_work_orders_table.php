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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('estimate_hour')->nullable();
            $table->integer('estimate_minute')->nullable();
            $table->string('schedule_period')->nullable();
            $table->string('schedule_period_time')->nullable();
            $table->enum('selected_time', ['no','daily', 'weekly', 'monthly','yearly'])->default('no');
            $table->string('created_by')->nullable();
            $table->string('no_of_repetitions')->nullable();
            $table->enum('priority', ['no','low', 'medium', 'high'])->default('no');
            $table->enum('status', ['open', 'onhold', 'in_progress', 'completed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};

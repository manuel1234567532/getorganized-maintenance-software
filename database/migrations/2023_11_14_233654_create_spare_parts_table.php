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
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('location_number')->nullable();
            $table->string('spare_part_number');
            $table->string('price_per_piece');
            $table->string('total_price');
            $table->string('image');
            $table->string('name_of_part');
            $table->string('supplier');
            $table->integer('current_stock');
            $table->integer('minimum_stock');
            $table->string('qr_code')->nullable();
            $table->enum('status', ['in_stock', 'out_of_stock','minimum_reached'])->default('in_stock');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};

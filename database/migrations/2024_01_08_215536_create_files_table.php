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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('uploaded_by', 255); // varchar(255)
            $table->string('file_name', 255); // varchar(255)
            $table->decimal('file_size', 50, 0); // decimal(50,0)
            $table->string('file_path', 255); // varchar(255)
            $table->string('current_folder', 255); // varchar(255)
            $table->string('status', 255); // varchar(255)
            $table->timestamps(); // created_at und updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
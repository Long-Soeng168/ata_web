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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description'); // Adding description column
            $table->string('original_path');
            $table->string('path_360p')->nullable();
            $table->string('path_480p')->nullable();
            $table->string('path_720p')->nullable();
            $table->string('path_1080p')->nullable();
            $table->enum('status', ['free', 'price'])->default('free');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};

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
        Schema::create('garages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('location');
            $table->unsignedBigInteger('user_id');
            $table->integer('like')->default(0);
            $table->integer('unlike')->default(0);
            $table->integer('rate')->default(0);
            $table->text('comment')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garages');
    }
};

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
        Schema::create('pet_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ownerId')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('Personality');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('whight');
            $table->string('type');
            $table->enum('status', ['health', 'sick', 'unknown']);
            $table->enum('categore', ['Dogs', 'Cats', ' birds', 'other']);
            $table->text('description');
            $table->unsignedTinyInteger('age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_infos');
    }
};

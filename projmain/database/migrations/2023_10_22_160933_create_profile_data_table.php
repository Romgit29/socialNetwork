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
        Schema::create('profile_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('profile_pic')->nullable();
            $table->foreign('profile_pic')->references('id')->on('pictures')->onDelete('set null');
            $table->unsignedBigInteger('profile_pic_thumbnail')->nullable();
            $table->foreign('profile_pic_thumbnail')->references('id')->on('pictures')->onDelete('set null');
            $table->unsignedBigInteger('background_image')->nullable();
            $table->foreign('background_image')->references('id')->on('pictures')->onDelete('set null');
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_data');
    }
};

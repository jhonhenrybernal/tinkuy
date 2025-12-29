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
        Schema::create('banner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_id'); // Foreign key to banners table
            $table->string('language_code'); // Language code (e.g., 'en', 'fr', 'de')
            $table->string('title'); // Translated title of the
            $table->text('description')->nullable();
            $table->string('image_url');
            $table->timestamps(); // Created at and updated at timestamps
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
            $table->unique(['banner_id', 'language_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_translations');
    }
};

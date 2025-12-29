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
        Schema::create('social_media_link_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_media_link_id'); // Foreign key to the social_media_links table
            $table->string('language_code');
            $table->string('name');
            $table->timestamps();

            $table->foreign('social_media_link_id')->references('id')->on('social_media_links')->onDelete('cascade');

            // Define a shorter name for the unique index
            $table->unique(['social_media_link_id', 'language_code'], 'social_media_link_translations_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_link_translations');
    }
};

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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name'); // The name of the site
            $table->string('tagline'); // Tagline of the site
            $table->string('meta_title'); // Meta title for SEO
            $table->string('meta_description'); // Meta description for SEO
            $table->string('meta_keywords')->nullable(); // Meta keywords for SEO (optional)
            $table->string('logo')->nullable(); // Path to the site logo image (optional)
            $table->string('favicon')->nullable(); // Path to the favicon image (optional)
            $table->string('contact_email')->nullable(); // Contact email address (optional)
            $table->string('contact_phone')->nullable(); // Contact phone number (optional)
            $table->string('address')->nullable(); // Site address (optional)
            $table->text('footer_text')->nullable(); // Footer text for the site (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

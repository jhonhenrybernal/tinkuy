
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
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['facebook', 'instagram', 'tiktok', 'youtube', 'x']);
            $table->string('platform'); // Name of the social media platform (e.g., Facebook, Twitter, etc.)
            $table->string('link'); // URL link to the social media profile/page
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
    }
};

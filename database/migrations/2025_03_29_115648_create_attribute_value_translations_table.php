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
        Schema::create('attribute_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_value_id')
                ->constrained('attribute_values', 'id')
                ->onDelete('cascade')
                ->index('av_trans_value_fk');

            $table->string('language_code', 5);
            $table->string('translated_value');

            // Shorter unique constraint name
            $table->unique(['attribute_value_id', 'language_code'], 'av_trans_lang_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_value_translations');
    }
};

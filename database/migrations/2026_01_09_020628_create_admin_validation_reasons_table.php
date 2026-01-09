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
        Schema::create('admin_validation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('value')->unique(); // value: ej 'typo', 'incomplete', 'other_custom_...'
            $table->string('label');           // label visible
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // si viene “de fábrica”
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_validation_reasons');
    }
};

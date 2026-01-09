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
         Schema::create('admin_validation_fields', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // value: ej 'brand_name', 'company_nit'
            $table->string('label');           // label visible: 'Nombre de la marca'
            $table->enum('applies_to', ['informal', 'natural', 'juridica', 'all'])->default('all');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_validation_fields');
    }
};

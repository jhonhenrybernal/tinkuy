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
        Schema::table('vendors', function (Blueprint $table) {
            $table->text('description')->nullable()->after('status');

            // opción 1: guardar el tipo de página como string
            $table->enum('page_type', ['landing_1', 'landing_2', 'landing_3'])
                  ->default('landing_1')
                  ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['description', 'page_type']);
        });
    }
};

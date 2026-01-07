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
            // Tipo de proveedor: informal | natural | juridica
            $table->string('vendor_type', 20)
                ->default('informal')
                ->after('id');

            // Información personal
            $table->string('brand_name', 255)
                ->nullable()
                ->after('name'); // nombre comercial / marca

            $table->string('personal_document_type', 10)
                ->nullable()
                ->after('brand_name');

            $table->string('personal_document_number', 50)
                ->nullable()
                ->after('personal_document_type');

            $table->string('city', 100)
                ->nullable()
                ->after('personal_document_number');

            // Información empresa (persona jurídica)
            $table->string('company_name', 255)
                ->nullable()
                ->after('city'); // razón social

            $table->string('company_nit', 50)
                ->nullable()
                ->after('company_name');

            $table->string('company_nit_dv', 10)
                ->nullable()
                ->after('company_nit');

            $table->string('legal_representative_name', 255)
                ->nullable()
                ->after('company_nit_dv');

            $table->string('legal_representative_document_type', 10)
                ->nullable()
                ->after('legal_representative_name');

            $table->string('legal_representative_document_number', 50)
                ->nullable()
                ->after('legal_representative_document_type');

            // Archivos PDF (RUT y Cámara de comercio) -> se guarda la ruta
            $table->string('legal_rut', 255)
                ->nullable()
                ->after('legal_representative_document_number');

            $table->string('legal_chamber', 255)
                ->nullable()
                ->after('legal_rut');

            // Proveedor de facturación
            $table->string('billing_provider', 50)
                ->default('internal')
                ->after('company_media');  // company_media es tu JSON de banners/imágenes

            $table->string('billing_user', 255)
                ->nullable()
                ->after('billing_provider');

            $table->text('billing_notes')
                ->nullable()
                ->after('billing_user');

            // Aceptación de términos y condiciones
            $table->boolean('terms_accepted')
                ->default(false)
                ->after('billing_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'vendor_type',
                'brand_name',
                'personal_document_type',
                'personal_document_number',
                'city',
                'company_name',
                'company_nit',
                'company_nit_dv',
                'legal_representative_name',
                'legal_representative_document_type',
                'legal_representative_document_number',
                'legal_rut',
                'legal_chamber',
                'billing_provider',
                'billing_user',
                'billing_notes',
                'terms_accepted',
            ]);
        });
    }
};

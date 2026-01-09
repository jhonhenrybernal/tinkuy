<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminValidationField;

class AdminValidationFieldsSeeder extends Seeder
{
    public function run(): void
    {
        // Comunes para informal/natural/juridica (applies_to = all)
        $common = [
            ['key' => 'name',                     'label' => 'Nombre completo',                         'applies_to' => 'all', 'sort_order' => 10],
            ['key' => 'brand_name',               'label' => 'Nombre de la marca / nombre comercial',   'applies_to' => 'all', 'sort_order' => 20],
            ['key' => 'personal_document_type',   'label' => 'Tipo de documento (persona)',            'applies_to' => 'all', 'sort_order' => 30],
            ['key' => 'personal_document_number', 'label' => 'Número de documento (persona)',          'applies_to' => 'all', 'sort_order' => 40],
            ['key' => 'city',                     'label' => 'Ubicación (ciudad)',                     'applies_to' => 'all', 'sort_order' => 50],

            ['key' => 'email',                    'label' => 'Correo electrónico',                     'applies_to' => 'all', 'sort_order' => 60],
            ['key' => 'phone',                    'label' => 'Teléfono',                               'applies_to' => 'all', 'sort_order' => 70],
            ['key' => 'status',                   'label' => 'Estado',                                 'applies_to' => 'all', 'sort_order' => 80],

            ['key' => 'profile_image',            'label' => 'Logo',                                   'applies_to' => 'all', 'sort_order' => 90],
            ['key' => 'description',              'label' => 'Descripción',                            'applies_to' => 'all', 'sort_order' => 100],
            ['key' => 'banners',                  'label' => 'Banners',                                'applies_to' => 'all', 'sort_order' => 110],
            ['key' => 'company_media',            'label' => 'Imágenes / video de empresa',            'applies_to' => 'all', 'sort_order' => 120],
        ];

        // Exclusivos de juridica (applies_to = juridica)
        $juridica = [
            ['key' => 'company_name',                       'label' => 'Razón social',                  'applies_to' => 'juridica', 'sort_order' => 200],
            ['key' => 'company_nit',                        'label' => 'NIT',                           'applies_to' => 'juridica', 'sort_order' => 210],
            ['key' => 'company_nit_dv',                     'label' => 'DV',                            'applies_to' => 'juridica', 'sort_order' => 220],
            ['key' => 'legal_representative_name',          'label' => 'Representante legal',           'applies_to' => 'juridica', 'sort_order' => 230],
            ['key' => 'legal_representative_document_type', 'label' => 'Tipo doc representante',        'applies_to' => 'juridica', 'sort_order' => 240],
            ['key' => 'legal_representative_document_number','label'=> 'Número doc representante',      'applies_to' => 'juridica', 'sort_order' => 250],
            ['key' => 'legal_rut',                          'label' => 'RUT (PDF)',                     'applies_to' => 'juridica', 'sort_order' => 260],
            ['key' => 'legal_chamber',                      'label' => 'Cámara de comercio (PDF)',      'applies_to' => 'juridica', 'sort_order' => 270],
        ];

        $fields = array_merge($common, $juridica);

        foreach ($fields as $f) {
            AdminValidationField::updateOrCreate(
                ['key' => $f['key']],
                [
                    'label'      => $f['label'],
                    'applies_to' => $f['applies_to'],
                    'is_active'  => true,
                    'sort_order' => $f['sort_order'],
                ]
            );
        }
    }
}

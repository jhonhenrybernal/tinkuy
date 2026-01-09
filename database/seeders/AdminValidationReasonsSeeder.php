<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminValidationReason;

class AdminValidationReasonsSeeder extends Seeder
{
     public function run(): void
    {
        $reasons = [
            ['value' => 'typo',            'label' => 'Mal escrito / ortografía',              'is_system' => true, 'sort_order' => 10],
            ['value' => 'incomplete',      'label' => 'Incompleto / falta información',       'is_system' => true, 'sort_order' => 20],
            ['value' => 'invalid_format',  'label' => 'Formato inválido',                      'is_system' => true, 'sort_order' => 30],
            ['value' => 'inconsistent',    'label' => 'Inconsistente con otros datos',        'is_system' => true, 'sort_order' => 40],
            ['value' => 'unreadable_file', 'label' => 'Archivo no legible',                   'is_system' => true, 'sort_order' => 50],
            ['value' => 'expired_document','label' => 'Documento vencido',                    'is_system' => true, 'sort_order' => 60],
            ['value' => 'duplicate',       'label' => 'Dato duplicado / ya existe',           'is_system' => true, 'sort_order' => 70],
            ['value' => 'does_not_apply',  'label' => 'No aplica',                             'is_system' => true, 'sort_order' => 80],

            // ojo: este se mantiene SIEMPRE para disparar el input de "Especificar"
            ['value' => 'other',           'label' => 'Agregar otro...',                       'is_system' => true, 'sort_order' => 999],
        ];

        foreach ($reasons as $r) {
            AdminValidationReason::updateOrCreate(
                ['value' => $r['value']],
                [
                    'label'      => $r['label'],
                    'is_active'  => true,
                    'is_system'  => $r['is_system'],
                    'sort_order' => $r['sort_order'],
                ]
            );
        }
    }
}

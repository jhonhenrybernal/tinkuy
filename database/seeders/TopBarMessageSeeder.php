<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopBarMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpia los mensajes anteriores
        DB::table('top_bar_messages')->truncate();

        DB::table('top_bar_messages')->insert([
            [
                'title' => 'Envío gratuito',
                'content_html' => '<strong>Envío gratuito</strong> en pedidos superiores a $50',
                'starts_at' => null,
                'ends_at' => null,
                'is_active' => true,
                'priority' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Soporte',
                'content_html' => '<a href="/contacto">Soporte</a> disponible para ayudarte',
                'starts_at' => null,
                'ends_at' => null,
                'is_active' => true,
                'priority' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tiendas',
                'content_html' => '<a href="/tiendas">Localizador de tiendas</a>',
                'starts_at' => null,
                'ends_at' => null,
                'is_active' => true,
                'priority' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

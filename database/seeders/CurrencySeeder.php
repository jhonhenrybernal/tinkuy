<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('currencies')->truncate();
        DB::table('currencies')->insert([
            [
                'name' => 'COP Pesos Colombianos',
                'code' => 'COP',
                'symbol' => '$',
                'exchange_rate' => 4150.0000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'US Dollar',
            //     'code' => 'USD',
            //     'symbol' => '$',
            //     'exchange_rate' => 4.150,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'Euro',
            //     'code' => 'EUR',
            //     'symbol' => '€',
            //     'exchange_rate' => 0.9200,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'British Pound',
            //     'code' => 'GBP',
            //     'symbol' => '£',
            //     'exchange_rate' => 0.7900,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}

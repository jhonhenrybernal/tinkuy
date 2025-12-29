<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // 1. Obtener algunos productos reales
        $products = DB::table('products')->pluck('id');

        // Si no hay productos, no tiene sentido crear órdenes
        if ($products->count() === 0) {
            return;
        }

        // Garantizar al menos 2 ids (si solo hay 1, repetimos)
        $product1Id = $products[0];
        $product2Id = $products[1] ?? $product1Id;

        // 2. Insertar órdenes y capturar IDs
        $order1Id = DB::table('orders')->insertGetId([
            'customer_id'  => null,
            'guest_email'  => 'guest1@example.com',
            'total_amount' => 300,
            'status'       => 'completed',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $order2Id = DB::table('orders')->insertGetId([
            'customer_id'  => null,
            'guest_email'  => 'guest2@example.com',
            'total_amount' => 150,
            'status'       => 'pending',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // 3. Insertar detalles usando IDs de productos reales
        DB::table('order_details')->insert([
            [
                'order_id'   => $order1Id,
                'product_id' => $product1Id,
                'quantity'   => 2,
                'price'      => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id'   => $order1Id,
                'product_id' => $product2Id,
                'quantity'   => 1,
                'price'      => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id'   => $order2Id,
                'product_id' => $product1Id,
                'quantity'   => 3,
                'price'      => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

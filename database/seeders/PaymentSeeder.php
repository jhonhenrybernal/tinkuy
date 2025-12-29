<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'testuser@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $gateway = PaymentGateway::firstOrCreate(
            ['code' => 'stripe'],
            ['name' => 'Stripe']
        );

        $order = Order::create([
            'customer_id' => null,
            'guest_email' => 'guest@example.com',
            'total_amount' => 100.00,
            'status' => 'pending',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'gateway_id' => $gateway->id,
            'amount' => 100.00,
            'currency' => 'USD',
            'status' => 'completed',
            'transaction_id' => Str::uuid(),
            'response' => ['message' => 'Payment successful'],
            'meta' => ['ip' => '127.0.0.1'],
        ]);
    }
}

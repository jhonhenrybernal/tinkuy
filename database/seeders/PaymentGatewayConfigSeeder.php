<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewayConfig;
use Illuminate\Database\Seeder;

class PaymentGatewayConfigSeeder extends Seeder
{
    public function run(): void
    {
        $paypal = PaymentGateway::where('code', 'paypal')->first();
        $stripe = PaymentGateway::where('code', 'stripe')->first();

        if ($paypal) {
            PaymentGatewayConfig::firstOrCreate(
                ['gateway_id' => $paypal->id, 'key_name' => 'client_id'],
                ['key_value' => env('PAYPAL_CLIENT_ID', 'your-paypal-client-id'), 'is_encrypted' => false, 'environment' => 'sandbox']
            );

            PaymentGatewayConfig::firstOrCreate(
                ['gateway_id' => $paypal->id, 'key_name' => 'client_secret'],
                ['key_value' => env('PAYPAL_CLIENT_SECRET', 'your-paypal-secret'), 'is_encrypted' => true, 'environment' => 'sandbox']
            );
        }

        if ($stripe) {
            PaymentGatewayConfig::firstOrCreate(
                ['gateway_id' => $stripe->id, 'key_name' => 'secret_key'],
                ['key_value' => env('STRIPE_SECRET', 'your-stripe-secret'), 'is_encrypted' => true, 'environment' => 'sandbox']
            );

            PaymentGatewayConfig::firstOrCreate(
                ['gateway_id' => $stripe->id, 'key_name' => 'public_key'],
                ['key_value' => env('STRIPE_PUBLIC', 'your-stripe-public'), 'is_encrypted' => false, 'environment' => 'sandbox']
            );
        }
    }
}

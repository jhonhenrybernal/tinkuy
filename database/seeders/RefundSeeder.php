<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    public function run(): void
    {
        $payment = Payment::first();

        if ($payment) {
            Refund::firstOrCreate(
                ['payment_id' => $payment->id],
                [
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'status' => 'requested',
                    'reason' => 'Test refund',
                    'response' => ['message' => 'Refund requested'],
                ]
            );
        }
    }
}

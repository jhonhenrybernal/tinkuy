<?php

namespace App\Http\Controllers\Store\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Services\PaymentGateway\PaymentManager;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $stripe = PaymentManager::make('stripe', 'sandbox'); // fetch service dynamically

        // $10 = 1000 cents
        $intent = $stripe->createPaymentIntent(1000, 'usd');

        return response()->json([
            'publicKey' => $stripe->getPublicKey(),
            'clientSecret' => $intent->client_secret,
        ]);
    }
}

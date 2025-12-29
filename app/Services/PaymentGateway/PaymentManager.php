<?php

namespace App\Services\PaymentGateway;

use App\Models\PaymentGateway;
use InvalidArgumentException;

class PaymentManager
{
    /**
     * Create a payment service instance for the given gateway code.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function make(string $gatewayCode, string $environment = 'sandbox')
    {
        // Check if gateway exists & active
        $gateway = PaymentGateway::where('code', $gatewayCode)
            ->where('is_active', true)
            ->first();

        if (! $gateway) {
            throw new InvalidArgumentException("Payment gateway [{$gatewayCode}] not found or inactive.");
        }

        // Map gateway codes to their service classes
        $services = [
            'paypal' => PayPalService::class,
            'stripe' => StripeService::class,
            // 'razorpay' => RazorpayService::class,
        ];

        if (! array_key_exists($gatewayCode, $services)) {
            throw new InvalidArgumentException("No service class found for [{$gatewayCode}].");
        }

        $serviceClass = $services[$gatewayCode];

        return new $serviceClass($environment);
    }
}

<?php

namespace App\Services\PaymentGateway;

class PaymentGatewayFactory
{
    /**
     * Create payment gateway instance based on method
     */
    public static function create(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'stripe' => new StripeGateway(),
            'paypal' => new PayPalGateway(),
            'chappa' => new ChappaGateway(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}"),
        };
    }

    /**
     * Get available gateways
     */
    public static function getAvailableGateways(): array
    {
        $gateways = [];

        if (config('services.stripe.secret')) {
            $gateways[] = [
                'id' => 'stripe',
                'name' => 'Stripe',
                'methods' => ['card', 'apple_pay', 'google_pay'],
                'currencies' => ['USD', 'EUR', 'GBP', 'ETB'],
            ];
        }

        if (config('services.paypal.client_id')) {
            $gateways[] = [
                'id' => 'paypal',
                'name' => 'PayPal',
                'methods' => ['paypal'],
                'currencies' => ['USD', 'EUR', 'GBP'],
            ];
        }

        if (config('services.chappa.secret_key')) {
            $gateways[] = [
                'id' => 'chappa',
                'name' => 'Chappa',
                'methods' => ['telebirr', 'cbe_birr', 'mpesa', 'amole'],
                'currencies' => ['ETB'],
            ];
        }

        return $gateways;
    }
}

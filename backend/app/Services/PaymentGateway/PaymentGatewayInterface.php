<?php

namespace App\Services\PaymentGateway;

interface PaymentGatewayInterface
{
    /**
     * Process a payment
     *
     * @param array $paymentData Payment details
     * @return array Payment result
     */
    public function processPayment(array $paymentData): array;

    /**
     * Verify payment status
     *
     * @param string $transactionId Transaction ID
     * @return array Verification result
     */
    public function verifyPayment(string $transactionId): array;

    /**
     * Refund a payment
     *
     * @param string $transactionId Transaction ID
     * @param float|null $amount Refund amount (null for full refund)
     * @return array Refund result
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array;
}

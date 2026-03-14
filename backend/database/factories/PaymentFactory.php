<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'gateway' => 'chapa',
            'payment_method' => $this->faker->randomElement(['telebirr', 'cbe_birr', 'mpesa', 'amole']),
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'currency' => 'ETB',
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'expired']),
            'transaction_id' => 'TX-' . $this->faker->unique()->numerify('##########'),
            'reference_number' => 'REF-' . $this->faker->unique()->numerify('########'),
            'checkout_url' => 'https://checkout.chapa.co/' . $this->faker->uuid(),
            'gateway_response' => null,
            'webhook_data' => null,
            'failure_reason' => null,
            'processed_at' => null,
            'verified_at' => null,
            'expires_at' => now()->addMinutes(30),
        ];
    }

    /**
     * Indicate that the payment is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'processed_at' => null,
            'verified_at' => null,
        ]);
    }

    /**
     * Indicate that the payment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'processed_at' => now(),
            'verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the payment has failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'failure_reason' => $this->faker->sentence(),
            'processed_at' => now(),
        ]);
    }

    /**
     * Indicate that the payment has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expired',
            'expires_at' => now()->subMinutes(31),
        ]);
    }
}

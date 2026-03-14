<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function payment_model_has_correct_fillable_fields()
    {
        $payment = new Payment();
        
        $expectedFillable = [
            'order_id',
            'user_id',
            'gateway',
            'payment_method',
            'amount',
            'currency',
            'status',
            'transaction_id',
            'reference_number',
            'checkout_url',
            'gateway_response',
            'webhook_data',
            'failure_reason',
            'processed_at',
            'verified_at',
            'expires_at',
        ];
        
        $this->assertEquals($expectedFillable, $payment->getFillable());
    }

    /** @test */
    public function payment_model_has_correct_casts()
    {
        $payment = new Payment();
        $casts = $payment->getCasts();
        
        $this->assertEquals('decimal:2', $casts['amount']);
        $this->assertEquals('array', $casts['gateway_response']);
        $this->assertEquals('array', $casts['webhook_data']);
        $this->assertEquals('datetime', $casts['processed_at']);
        $this->assertEquals('datetime', $casts['verified_at']);
        $this->assertEquals('datetime', $casts['expires_at']);
    }

    /** @test */
    public function payment_belongs_to_order()
    {
        $payment = new Payment();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $payment->order()
        );
    }

    /** @test */
    public function payment_belongs_to_user()
    {
        $payment = new Payment();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $payment->user()
        );
    }
}

<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPaymentRelationshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function order_has_many_payments()
    {
        $order = new Order();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $order->payments()
        );
    }
}

<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Services\ChapaPaymentService;
use App\Services\PaymentGateway\ChappaGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class ChapaPaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    private ChapaPaymentService $service;
    private $gatewayMock;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock the ChappaGateway
        $this->gatewayMock = Mockery::mock(ChappaGateway::class);
        $this->service = new ChapaPaymentService($this->gatewayMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_initializes_payment_successfully()
    {
        // Create test user (staff member)
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Create test data
        $customer = Customer::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test Customer',
        ]);

        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'order_number' => 'ORD-20240101-ABC123',
            'total' => 1000.00,
            'status' => 'pending',
        ]);

        // Ensure customer relationship is loaded
        $order->load('customer');

        // Mock gateway response - use any() for more flexible matching
        $this->gatewayMock
            ->shouldReceive('processPayment')
            ->once()
            ->andReturn([
                'success' => true,
                'transaction_id' => 'TX-123456',
                'checkout_url' => 'https://checkout.chapa.co/test',
                'status' => 'pending',
            ]);

        // Execute
        $result = $this->service->initializePayment($order);

        // Assert
        $this->assertTrue($result['success'], 'Expected success to be true, but got: ' . json_encode($result));
        $this->assertEquals('https://checkout.chapa.co/test', $result['checkout_url']);
        $this->assertEquals('TX-123456', $result['transaction_id']);
        $this->assertNull($result['error']);

        // Verify payment record created
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'transaction_id' => 'TX-123456',
            'gateway' => 'chapa',
            'amount' => 1000.00,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_returns_error_when_order_already_completed()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
        ]);

        $result = $this->service->initializePayment($order);

        $this->assertFalse($result['success']);
        $this->assertEquals('Order already completed', $result['error']);
        $this->assertNull($result['checkout_url']);
        $this->assertNull($result['transaction_id']);
    }

    /** @test */
    public function it_returns_error_when_payment_already_exists()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        // Create existing payment
        Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
        ]);

        $result = $this->service->initializePayment($order);

        $this->assertFalse($result['success']);
        $this->assertEquals('Payment already exists for this order', $result['error']);
    }

    /** @test */
    public function it_handles_gateway_failure()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        // Mock gateway failure
        $this->gatewayMock
            ->shouldReceive('processPayment')
            ->once()
            ->andReturn([
                'success' => false,
                'error' => 'Payment gateway unavailable',
            ]);

        $result = $this->service->initializePayment($order);

        $this->assertFalse($result['success']);
        $this->assertEquals('Payment gateway unavailable', $result['error']);
        $this->assertNull($result['checkout_url']);
        $this->assertNull($result['transaction_id']);
    }

    /** @test */
    public function it_verifies_webhook_signature_correctly()
    {
        config(['services.chappa.webhook_secret' => 'test-secret']);

        $payload = ['tx_ref' => 'TX-123', 'status' => 'success'];
        $validSignature = hash_hmac('sha256', json_encode($payload), 'test-secret');

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('verifySignature');
        $method->setAccessible(true);

        $result = $method->invoke($this->service, $payload, $validSignature);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_rejects_invalid_webhook_signature()
    {
        config(['services.chappa.webhook_secret' => 'test-secret']);

        $payload = ['tx_ref' => 'TX-123', 'status' => 'success'];
        $invalidSignature = 'invalid-signature';

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('verifySignature');
        $method->setAccessible(true);

        $result = $method->invoke($this->service, $payload, $invalidSignature);

        $this->assertFalse($result);
    }

    /** @test */
    public function it_handles_webhook_successfully()
    {
        config(['services.chappa.webhook_secret' => 'test-secret']);

        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'pending',
        ]);

        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'transaction_id' => 'TX-123456',
            'status' => 'pending',
        ]);

        $payload = [
            'tx_ref' => 'TX-123456',
            'status' => 'success',
            'payment_method' => 'telebirr',
        ];

        $signature = hash_hmac('sha256', json_encode($payload), 'test-secret');

        $result = $this->service->handleWebhook($payload, $signature);

        $this->assertTrue($result['success']);
        $this->assertEquals('Webhook processed successfully', $result['message']);

        // Verify payment updated
        $payment->refresh();
        $this->assertEquals('completed', $payment->status);
        $this->assertEquals('telebirr', $payment->payment_method);
        $this->assertNotNull($payment->verified_at);

        // Verify order status updated
        $order->refresh();
        $this->assertEquals('processing', $order->status);
    }

    /** @test */
    public function it_handles_duplicate_webhook_idempotently()
    {
        config(['services.chappa.webhook_secret' => 'test-secret']);

        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'processing',
        ]);

        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'transaction_id' => 'TX-123456',
            'status' => 'completed',
        ]);

        $payload = [
            'tx_ref' => 'TX-123456',
            'status' => 'success',
        ];

        $signature = hash_hmac('sha256', json_encode($payload), 'test-secret');

        $result = $this->service->handleWebhook($payload, $signature);

        $this->assertTrue($result['success']);
        $this->assertEquals('Payment already processed', $result['message']);
    }

    /** @test */
    public function it_marks_payment_as_expired()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create([
            'customer_id' => $customer->id,
        ]);

        $payment = Payment::factory()->create([
            'order_id' => $order->id,
            'transaction_id' => 'TX-EXPIRED',
            'status' => 'pending',
            'expires_at' => now()->subMinutes(31),
        ]);

        $this->service->markPaymentExpired('TX-EXPIRED');

        $payment->refresh();
        $this->assertEquals('expired', $payment->status);
    }
}

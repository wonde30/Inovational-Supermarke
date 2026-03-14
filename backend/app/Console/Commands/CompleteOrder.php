<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\ChapaPaymentService;
use Illuminate\Console\Command;

class CompleteOrder extends Command
{
    protected $signature = 'order:complete {order_number}';
    protected $description = 'Complete an order and create sale';

    public function handle(ChapaPaymentService $chapaService)
    {
        $orderNumber = $this->argument('order_number');
        
        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            $this->error("Order {$orderNumber} not found");
            return 1;
        }
        
        if ($order->status === 'completed') {
            $this->info("Order {$orderNumber} is already completed");
            return 0;
        }
        
        try {
            // Update payment
            $payment = $order->payments()->latest()->first();
            if ($payment) {
                $payment->update(['status' => 'completed', 'verified_at' => now()]);
            }
            
            // Complete order
            $chapaService->completeOrder($order, 'chapa');
            
            $this->info("Order {$orderNumber} completed successfully!");
            $this->info("Status: {$order->fresh()->status}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to complete order: " . $e->getMessage());
            return 1;
        }
    }
}

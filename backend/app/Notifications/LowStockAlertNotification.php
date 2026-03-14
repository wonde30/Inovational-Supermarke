<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Low Stock Alert - ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is an automated alert about low stock levels.')
            ->line('Product: ' . $this->product->name)
            ->line('SKU: ' . $this->product->sku)
            ->line('Current Stock: ' . $this->product->quantity)
            ->line('Reorder Level: ' . $this->product->reorder_level)
            ->action('View Product', url('/products/' . $this->product->id))
            ->line('Please reorder this product to avoid stock-outs.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'sku' => $this->product->sku,
            'current_stock' => $this->product->quantity,
            'reorder_level' => $this->product->reorder_level,
            'message' => "Low stock alert for {$this->product->name}",
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];
        
        if ($notifiable->phone) {
            $channels[] = 'sms';
        }
        
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Order Status Update - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your order status has been updated.')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Previous Status: ' . ucfirst($this->oldStatus))
            ->line('Current Status: ' . ucfirst($this->order->status));

        if ($this->order->status === 'completed') {
            $message->line('🎉 Your order has been completed!')
                   ->line('Thank you for shopping with us!');
        } elseif ($this->order->status === 'cancelled') {
            $message->line('Your order has been cancelled.')
                   ->line('If you have any questions, please contact our support team.');
        } elseif ($this->order->status === 'processing') {
            $message->line('Your order is being processed and will be ready soon.');
        }

        return $message->action('View Order', url('/orders/' . $this->order->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
            'message' => "Order status updated from {$this->oldStatus} to {$this->order->status}",
        ];
    }

    public function toSms(object $notifiable): string
    {
        $statusMessages = [
            'processing' => 'is being processed',
            'completed' => 'has been completed',
            'cancelled' => 'has been cancelled',
        ];

        $statusText = $statusMessages[$this->order->status] ?? 'status updated';
        
        return "Order {$this->order->order_number} {$statusText}. " .
               "View details: " . url('/orders/' . $this->order->id);
    }
}

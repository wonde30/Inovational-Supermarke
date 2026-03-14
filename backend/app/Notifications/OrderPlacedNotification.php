<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];
        
        // Add SMS if phone number exists
        if ($notifiable->phone) {
            $channels[] = 'sms';
        }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Confirmation - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for your order.')
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Total Amount: ' . number_format($this->order->total, 2) . ' ' . config('app.currency', 'ETB'))
            ->line('Status: ' . ucfirst($this->order->status))
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('We will notify you when your order is being processed.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'message' => 'Your order has been placed successfully.',
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): string
    {
        return "Order {$this->order->order_number} confirmed! Total: " . 
               number_format($this->order->total, 2) . " ETB. " .
               "Track your order at: " . url('/orders/' . $this->order->id);
    }
}

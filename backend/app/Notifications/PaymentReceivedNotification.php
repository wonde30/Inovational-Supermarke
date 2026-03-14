<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Payment $payment
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
        return (new MailMessage)
            ->subject('Payment Received - ' . $this->payment->transaction_id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We have received your payment.')
            ->line('Transaction ID: ' . $this->payment->transaction_id)
            ->line('Amount: ' . number_format($this->payment->amount, 2) . ' ' . config('app.currency', 'ETB'))
            ->line('Payment Method: ' . ucfirst(str_replace('_', ' ', $this->payment->payment_method)))
            ->line('Status: ' . ucfirst($this->payment->status))
            ->action('View Receipt', url('/payments/' . $this->payment->id))
            ->line('Thank you for your payment!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'transaction_id' => $this->payment->transaction_id,
            'amount' => $this->payment->amount,
            'payment_method' => $this->payment->payment_method,
            'status' => $this->payment->status,
            'message' => 'Payment received successfully.',
        ];
    }

    public function toSms(object $notifiable): string
    {
        return "Payment of " . number_format($this->payment->amount, 2) . " ETB received. " .
               "Transaction ID: {$this->payment->transaction_id}. " .
               "Thank you!";
    }
}

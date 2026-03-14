<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Throwable;

class CriticalErrorNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Throwable $exception,
        public array $context = []
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🚨 Critical Error Alert - IBMS')
            ->greeting('Critical Error Detected!')
            ->line('A critical error has occurred in the IBMS system.')
            ->line('Error: ' . $this->exception->getMessage())
            ->line('File: ' . $this->exception->getFile())
            ->line('Line: ' . $this->exception->getLine())
            ->line('Time: ' . now()->toDateTimeString())
            ->line('Please investigate immediately.')
            ->action('View Logs', url('/admin/logs'));
    }
}

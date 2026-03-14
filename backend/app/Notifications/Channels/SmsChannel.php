<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (!$phone = $notifiable->routeNotificationFor('sms', $notification)) {
            return;
        }

        $message = $notification->toSms($notifiable);

        $this->sendSms($phone, $message);
    }

    /**
     * Send SMS using configured provider
     */
    private function sendSms(string $phone, string $message): void
    {
        $provider = config('services.sms.provider', 'twilio');

        try {
            match ($provider) {
                'twilio' => $this->sendViaTwilio($phone, $message),
                'africastalking' => $this->sendViaAfricasTalking($phone, $message),
                'log' => $this->sendViaLog($phone, $message),
                default => throw new \Exception("Unsupported SMS provider: {$provider}"),
            };
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $phone,
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send via Twilio
     */
    private function sendViaTwilio(string $phone, string $message): void
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $from = config('services.twilio.from');

        Http::withBasicAuth($accountSid, $authToken)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'From' => $from,
                'To' => $phone,
                'Body' => $message,
            ]);
    }

    /**
     * Send via Africa's Talking (popular in Ethiopia/East Africa)
     */
    private function sendViaAfricasTalking(string $phone, string $message): void
    {
        $apiKey = config('services.africastalking.api_key');
        $username = config('services.africastalking.username');
        $from = config('services.africastalking.from');

        Http::withHeaders([
            'apiKey' => $apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://api.africastalking.com/version1/messaging', [
            'username' => $username,
            'to' => $phone,
            'message' => $message,
            'from' => $from,
        ]);
    }

    /**
     * Log SMS (for testing)
     */
    private function sendViaLog(string $phone, string $message): void
    {
        Log::info('SMS sent', [
            'to' => $phone,
            'message' => $message,
        ]);
    }
}

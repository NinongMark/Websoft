<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorLoginNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $code
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Login Verification Code')
            ->line('A login attempt was made to your account.')
            ->line('Your verification code is: **' . $this->code . '**')
            ->line('This code expires in 5 minutes.')
            ->line('If you did not request this, please ignore this email.')
            ->line('Do not reply to this email.');
    }
}


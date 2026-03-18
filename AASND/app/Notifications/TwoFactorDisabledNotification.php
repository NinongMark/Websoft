<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorDisabledNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channel.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Two-Factor Authentication Disabled')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Two-factor authentication has been disabled on your account.')
            ->line('Your account is now less secure. We recommend keeping two-factor authentication enabled.')
            ->line('If you did not disable two-factor authentication, please contact support immediately.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Two-Factor Authentication Disabled',
            'message' => 'Two-factor authentication has been disabled on your account.',
            'type' => 'security',
        ];
    }
}


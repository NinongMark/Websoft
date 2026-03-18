<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorEnabledNotification extends Notification
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
            ->subject('Two-Factor Authentication Enabled')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Two-factor authentication has been enabled on your account.')
            ->line('You will now be required to enter a verification code when logging in.')
            ->line('Please keep your recovery codes safe - you can use them to access your account if you lose your device.')
            ->action('View Recovery Codes', route('two-factor.recovery-codes'))
            ->line('If you did not enable two-factor authentication, please contact support immediately.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Two-Factor Authentication Enabled',
            'message' => 'Two-factor authentication has been enabled on your account.',
            'type' => 'security',
        ];
    }
}


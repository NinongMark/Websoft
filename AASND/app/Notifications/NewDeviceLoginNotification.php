<?php

namespace App\Notifications;

use App\Models\LoginLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceLoginNotification extends Notification
{
    use Queueable;

    protected LoginLog $loginLog;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoginLog $loginLog)
    {
        $this->loginLog = $loginLog;
    }

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
            ->subject('New Device Login Detected - PageTurner Bookstore')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We detected a login to your account from a new device.')
            ->line('**Login Details:**')
            ->line('- Device: ' . $this->loginLog->device_info)
            ->line('- IP Address: ' . $this->loginLog->ip_address)
            ->line('- Location: ' . ($this->loginLog->location ?? 'Unknown'))
            ->line('- Time: ' . $this->loginLog->login_at->format('M d, Y H:i:s'))
            ->line('If this was you, you can safely ignore this email.')
            ->line('If you did not log in from a new device, please change your password immediately and enable two-factor authentication.')
            ->action('Secure Your Account', route('profile.edit'))
            ->line('Thank you for using PageTurner Bookstore!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Device Login Detected',
            'message' => 'A new device logged into your account: ' . $this->loginLog->device_info,
            'login_log_id' => $this->loginLog->id,
            'type' => 'security',
        ];
    }
}


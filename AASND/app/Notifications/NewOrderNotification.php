<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected Order $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
            ->subject('New Order Received - Order #' . $this->order->id)
            ->greeting('Hello Admin!')
            ->line('A new order has been placed on PageTurner Bookstore.')
            ->line('Order ID: #' . $this->order->id)
            ->line('Customer: ' . $this->order->user->name)
            ->line('Email: ' . $this->order->user->email)
            ->line('Total Amount: $' . number_format($this->order->total_amount, 2))
            ->line('Status: ' . ucfirst($this->order->status))
            ->action('View Order', route('orders.show', $this->order))
            ->line('Please process this order accordingly.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Order Received',
            'message' => 'New order #' . $this->order->id . ' from ' . $this->order->user->name . '.',
            'order_id' => $this->order->id,
            'type' => 'order',
        ];
    }
}


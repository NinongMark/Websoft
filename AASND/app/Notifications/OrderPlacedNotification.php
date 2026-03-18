<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
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
            ->subject('Order Confirmation - Order #' . $this->order->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for your order!')
            ->line('Order ID: #' . $this->order->id)
            ->line('Total Amount: $' . number_format($this->order->total_amount, 2))
            ->line('Status: ' . ucfirst($this->order->status))
            ->line('You will receive an email when your order status changes.')
            ->action('View Order', route('orders.show', $this->order))
            ->line('Thank you for shopping with PageTurner Bookstore!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Placed Successfully',
            'message' => 'Your order #' . $this->order->id . ' has been placed successfully.',
            'order_id' => $this->order->id,
            'type' => 'order',
        ];
    }
}


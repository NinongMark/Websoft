<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    protected Order $order;
    protected string $oldStatus;
    protected string $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        $mail = (new MailMessage)
            ->subject('Order Status Updated - Order #' . $this->order->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your order status has been updated.')
            ->line('Order ID: #' . $this->order->id)
            ->line('Previous Status: ' . ucfirst($this->oldStatus))
            ->line('New Status: ' . ucfirst($this->newStatus));

        // Add specific message based on status
        if ($this->newStatus === 'completed') {
            $mail->line('Your order has been completed. Thank you for shopping with us!');
        } elseif ($this->newStatus === 'cancelled') {
            $mail->line('Your order has been cancelled. If you have any questions, please contact us.');
        } elseif ($this->newStatus === 'processing') {
            $mail->line('Your order is now being processed and will be shipped soon.');
        } elseif ($this->newStatus === 'pending') {
            $mail->line('Your order is pending and waiting for confirmation.');
        }

        return $mail
            ->action('View Order Details', route('orders.show', $this->order))
            ->line('Thank you for shopping with PageTurner Bookstore!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Status Updated',
            'message' => 'Your order #' . $this->order->id . ' status has been updated from ' . $this->oldStatus . ' to ' . $this->newStatus . '.',
            'order_id' => $this->order->id,
            'type' => 'order',
        ];
    }
}


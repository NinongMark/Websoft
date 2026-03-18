<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewStatusNotification extends Notification
{
    use Queueable;

    protected Review $review;
    protected string $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Review $review, string $status)
    {
        $this->review = $review;
        $this->status = $status;
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
        $statusText = $this->status === 'approved' ? 'approved' : 'rejected';
        
        return (new MailMessage)
            ->subject('Your Review Status Updated - PageTurner Bookstore')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your review for "' . $this->review->book->title . '" has been ' . $statusText . '.')
            ->line('**Review Details:**')
            ->line('- Rating: ' . str_repeat('★', $this->review->rating) . str_repeat('☆', 5 - $this->review->rating))
            ->line('- Status: ' . ucfirst($statusText))
            ->line('- Submitted: ' . $this->review->created_at->format('M d, Y'))
            ->when($this->status === 'rejected', function ($mail) {
                return $mail->line('Your review did not meet our community guidelines. Please ensure your review is constructive and relevant.');
            })
            ->when($this->status === 'approved', function ($mail) {
                return $mail->line('Thank you for sharing your thoughts! Your review is now visible to other customers.');
            })
            ->action('View Book', route('books.show', $this->review->book))
            ->line('Thank you for being part of the PageTurner community!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Review Status Updated',
            'message' => 'Your review for "' . $this->review->book->title . '" has been ' . $this->status,
            'review_id' => $this->review->id,
            'book_id' => $this->review->book->id,
            'status' => $this->status,
            'type' => 'review',
        ];
    }
}


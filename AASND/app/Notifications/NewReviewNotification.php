<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification
{
    use Queueable;

    protected Review $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
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
            ->subject('New Review Submitted - ' . $this->review->book->title)
            ->greeting('Hello Admin!')
            ->line('A new review has been submitted for a book.')
            ->line('Book: ' . $this->review->book->title)
            ->line('Reviewer: ' . $this->review->user->name)
            ->line('Rating: ' . str_repeat('★', $this->review->rating) . str_repeat('☆', 5 - $this->review->rating))
            ->when($this->review->comment, function ($message) {
                return $message->line('Comment: ' . $this->review->comment);
            })
            ->action('View Review', route('books.show', $this->review->book))
            ->line('Please review and moderate if necessary.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Review Submitted',
            'message' => 'New review for "' . $this->review->book->title . '" from ' . $this->review->user->name . '.',
            'review_id' => $this->review->id,
            'type' => 'review',
        ];
    }
}


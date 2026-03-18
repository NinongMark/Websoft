<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reviews.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the review.
     */
    public function view(User $user, Review $review): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create reviews.
     */
    public function create(User $user): bool
    {
        // User must have verified email to create reviews
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can verify their purchase for a book.
     */
    public function verifyPurchase(User $user, Review $review): bool
    {
        // Check if user has purchased the book
        $orderItems = $review->book->orderItems()
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->whereIn('status', ['processing', 'completed']);
            })
            ->get();

        return $orderItems->isNotEmpty();
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        // Only the owner can update their review
        return $review->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // Owner or admin can delete
        return $user->isAdmin() || $review->user_id === $user->id;
    }
}


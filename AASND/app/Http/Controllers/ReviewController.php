<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Notifications\NewReviewNotification;
use App\Notifications\ReviewStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['book_id'] = $book->id;
        $validated['status'] = 'pending'; // Default status is pending

        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReview) {
            $oldValues = $existingReview->toArray();
            $existingReview->update($validated);
            $message = 'Review updated successfully!';
            
            // Log the update in audit
            AuditLog::log(Auth::user(), 'update', Review::class, $existingReview->id, $oldValues, $validated);
        } else {
            $review = Review::create($validated);
            $message = 'Review submitted successfully! Your review is pending approval.';
            
            // Log the creation in audit
            AuditLog::log(Auth::user(), 'review_created', Review::class, $review->id, null, $validated);
            
            // Send notification to admin about new review
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new NewReviewNotification($review));
            }
        }

        return redirect()->route('books.show', $book)
            ->with('success', $message);
    }

    /**
     * Approve a review (admin only).
     */
    public function approve(Review $review)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $oldStatus = $review->status;
        $review->approve();

        // Log the approval
        AuditLog::log(Auth::user(), 'review_approved', Review::class, $review->id, ['status' => $oldStatus], ['status' => 'approved']);

        // Send notification to the user
        $review->user->notify(new ReviewStatusNotification($review, 'approved'));

        return back()->with('success', 'Review approved successfully!');
    }

    /**
     * Reject a review (admin only).
     */
    public function reject(Review $review)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $oldStatus = $review->status;
        $review->reject();

        // Log the rejection
        AuditLog::log(Auth::user(), 'review_rejected', Review::class, $review->id, ['status' => $oldStatus], ['status' => 'rejected']);

        // Send notification to the user => 'rejected
        $review->user->notify(new ReviewStatusNotification($review, 'rejected'));

        return back()->with('success', 'Review rejected!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Only allow owner or admin to delete
        if (Auth::id() !== $review->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $book = $review->book;
        
        // Log the deletion
        AuditLog::log(Auth::user(), 'delete', Review::class, $review->id, $review->toArray(), null);

        $review->delete();

        return redirect()->route('books.show', $book)
            ->with('success', 'Review deleted successfully!');
    }
}


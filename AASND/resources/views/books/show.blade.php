@extends('layouts.app')

@section('title', ($book->title) . ' - PageTurner')

@section('content')
<div class="book-show-container">
    {{-- Main Book Card --}}
    <div class="book-show-card">
        <div class="book-show-grid">
            {{-- Book Cover Section --}}
            <div class="book-cover-section">
                <div class="book-cover-wrapper">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover-image">
                    @else
                        <div class="book-cover-placeholder">
                            <svg class="book-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Book Details Section --}}
            <div class="book-details-section">
                <div class="book-category-badge">{{ $book->category->name }}</div>
                <h1 class="book-title">{{ $book->title }}</h1>
                <p class="book-author">by {{ $book->author }}</p>
                
                {{-- Rating --}}
                <div class="book-rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($book->average_rating))
                                <svg class="star-filled" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="star-empty" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-text">{{ number_format($book->average_rating, 1) }} ({{ $book->reviews->count() }} reviews)</span>
                </div>
                
                {{-- Price --}}
₱{{ number_format($book->price, 2) }}
                
                {{-- Stock Status --}}
                <div class="stock-status {{ $book->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                    @if($book->stock_quantity > 0)
                        <svg class="status-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>In Stock ({{ $book->stock_quantity }} available)</span>
                    @else
                        <svg class="status-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>Out of Stock</span>
                    @endif
                </div>
                
                {{-- ISBN --}}
                <div class="book-isbn">
                    <span class="isbn-label">ISBN:</span> {{ $book->isbn }}
                </div>
                
                {{-- Description --}}
                <div class="book-description">
                    <h3>Description</h3>
                    <p>{{ $book->description }}</p>
                </div>
                
                {{-- Order Form --}}
                @auth
                    @if(!auth()->user()->isAdmin())
                        @if($book->stock_quantity > 0)
                            <form action="{{ route('orders.store') }}" method="POST" class="order-form">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="order-form-row">
                                    <div class="quantity-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $book->stock_quantity }}" class="quantity-input">
                                    </div>
                                    <button type="submit" class="btn-add-to-cart">
                                        <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Place Order
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif
                @else
                    <div class="login-prompt">
                        <a href="{{ route('login') }}" class="login-link">Login</a> to place an order.
                    </div>
                @endauth
                
                {{-- Admin Actions --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="admin-actions">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn-edit">
                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Book
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete Book
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews-section">
        <h2 class="reviews-title">Customer Reviews</h2>
        
        {{-- Review Form --}}
        @auth
            <div class="review-form-card">
                <h3 class="review-form-title">Write a Review</h3>
                <form action="{{ route('reviews.store', $book) }}" method="POST" class="review-form">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select id="rating" name="rating" class="form-select" required>
                            <option value="">Select rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea id="comment" name="comment" rows="4" class="form-textarea" placeholder="Share your thoughts about this book..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit-review">
                        Submit Review
                    </button>
                </form>
            </div>
        @else
            <div class="review-login-prompt">
                <a href="{{ route('login') }}" class="login-link">Login</a> to write a review.
            </div>
        @endauth
        
        {{-- Display Reviews --}}
        @forelse($book->reviews()->approved()->get() as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="reviewer-name">{{ $review->user->name }}</p>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="star-filled-sm" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="star-empty-sm" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="review-meta">
                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                        @auth
                            @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="delete-review-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-review">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
                @if($review->comment)
                    <p class="review-comment">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <div class="no-reviews">
                <svg class="no-reviews-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p>No reviews yet. Be the first to review this book!</p>
            </div>
        @endforelse
        
        {{-- Admin Review Management --}}
        @auth
            @if(auth()->user()->isAdmin())
                <div class="pending-reviews-section">
                    <h3 class="pending-title">Pending Reviews (Admin)</h3>
                    @forelse($book->reviews()->pending()->get() as $review)
                        <div class="pending-review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar pending">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="reviewer-name">{{ $review->user->name }}</p>
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="star-filled-sm" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @else
                                                    <svg class="star-empty-sm" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="pending-badge">Pending</span>
                            </div>
                            @if($review->comment)
                                <p class="review-comment">{{ $review->comment }}</p>
                            @endif
                            <div class="pending-actions">
                                <form action="{{ route('reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-approve">Approve</button>
                                </form>
                                <form action="{{ route('reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-reject">Reject</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="no-pending">No pending reviews.</p>
                    @endforelse
                </div>
            @endif
        @endauth
    </div>
</div>

<style>
    /* Book Show Page Styles */
    .book-show-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    /* Main Card */
    .book-show-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .book-show-grid {
        display: grid;
        grid-template-columns: 1fr;
    }
    
    @media (min-width: 768px) {
        .book-show-grid {
            grid-template-columns: 350px 1fr;
        }
    }
    
    /* Cover Section */
    .book-cover-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media (min-width: 768px) {
        .book-cover-section {
            padding: 3rem;
        }
    }
    
    .book-cover-wrapper {
        width: 100%;
        max-width: 280px;
        aspect-ratio: 2/3;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
    
    .book-cover-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .book-cover-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
    }
    
    .book-icon {
        width: 5rem;
        height: 5rem;
        color: #94a3b8;
    }
    
    /* Details Section */
    .book-details-section {
        padding: 2rem;
    }
    
    @media (min-width: 768px) {
        .book-details-section {
            padding: 2.5rem;
        }
    }
    
    .book-category-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        margin-bottom: 0.75rem;
    }
    
    .book-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
    }
    
    @media (min-width: 768px) {
        .book-title {
            font-size: 2.25rem;
        }
    }
    
    .book-author {
        font-size: 1.125rem;
        color: #64748b;
        margin: 0;
    }
    
    /* Rating */
    .book-rating {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .stars {
        display: flex;
        gap: 0.125rem;
    }
    
    .stars svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    
.star-filled {
        color: #fbbf24 !important;
    }
    
.star-empty {
        color: #d1d5db !important;
    }
    
    .rating-text {
        font-size: 0.875rem;
        color: #64748b;
    }
    
    /* Price */
    .book-price {
        font-size: 2rem;
        font-weight: 700;
        color: #4f46e5;
        margin-top: 1rem;
    }
    
    /* Stock Status */
    .stock-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.75rem;
    }
    
    .stock-status .status-icon {
        width: 1.25rem;
        height: 1.25rem;
    }
    
    .stock-status.in-stock {
        color: #059669;
    }
    
    .stock-status.out-of-stock {
        color: #dc2626;
    }
    
    /* ISBN */
    .book-isbn {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.75rem;
    }
    
    .isbn-label {
        font-weight: 600;
        color: #475569;
    }
    
    /* Description */
    .book-description {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .book-description h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }
    
    .book-description p {
        font-size: 0.9375rem;
        color: #475569;
        line-height: 1.7;
        margin: 0;
    }
    
    /* Order Form */
    .order-form {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .order-form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }
    
    .quantity-group {
        flex: 0 0 auto;
    }
    
.quantity-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827 !important;
        margin-bottom: 0.5rem;
    }
    
    .quantity-input {
        width: 100px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    .btn-add-to-cart {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .btn-add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }
    
    .btn-add-to-cart:active {
        transform: translateY(0);
    }
    
    .cart-icon {
        width: 1.25rem;
        height: 1.25rem;
    }
    
    .login-prompt {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #eff6ff;
        border-radius: 0.5rem;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        font-size: 0.9375rem;
    }
    
    .login-link {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
    }
    
    .login-link:hover {
        text-decoration: underline;
    }
    
    /* Admin Actions */
    .admin-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-edit {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }
    
    .btn-edit:hover {
        background: #fde68a;
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    
    .btn-delete:hover {
        background: #fecaca;
    }
    
    .btn-icon {
        width: 1rem;
        height: 1rem;
    }
    
    /* Reviews Section */
    .reviews-section {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    
.reviews-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827 !important;
        margin: 0 0 1.5rem 0;
    }
    
    /* Review Form */
    .review-form-card {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
.review-form-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827 !important;
        margin: 0 0 1.25rem 0;
    }
    
    .review-form .form-group {
        margin-bottom: 1rem;
    }
    
.review-form label {
        color: #111827 !important;
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
.form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        color: #111827 !important;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
.form-select:focus, .form-textarea:focus {
        outline: none;
        color: #111827 !important;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .btn-submit-review {
        padding: 0.75rem 1.5rem;
        background: #4f46e5;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.2s;
    }
    
    .btn-submit-review:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }
    
    .review-login-prompt {
        padding: 1rem;
        background: #eff6ff;
        border-radius: 0.5rem;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
    }
    
    /* Review Cards */
    .review-card {
        padding: 1.25rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s;
    }
    
    .review-card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .reviewer-info {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .reviewer-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .reviewer-avatar.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .reviewer-name {
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .review-rating {
        display: flex;
        gap: 0.125rem;
        margin-top: 0.25rem;
    }
    
    .review-rating svg {
        width: 0.875rem;
        height: 0.875rem;
    }
    
.star-filled-sm {
        color: #fbbf24 !important;
    }
    
.star-empty-sm {
        color: #d1d5db !important;
    }
    
    .review-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .review-date {
        font-size: 0.8125rem;
        color: #94a3b8;
    }
    
    .delete-review-form {
        margin: 0;
    }
    
    .btn-delete-review {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 0.8125rem;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s;
    }
    
    .btn-delete-review:hover {
        background: #fee2e2;
    }
    
    .review-comment {
        margin: 1rem 0 0 0;
        color: #475569;
        line-height: 1.6;
        font-size: 0.9375rem;
    }
    
    /* No Reviews */
    .no-reviews {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }
    
    .no-reviews-icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 1rem;
        color: #94a3b8;
    }
    
    .no-reviews p {
        margin: 0;
        font-size: 1rem;
    }
    
    /* Pending Reviews */
    .pending-reviews-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .pending-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 1.25rem 0;
    }
    
    .pending-review-card {
        padding: 1.25rem;
        border: 1px solid #fcd34d;
        border-left-width: 4px;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        background: #fffbeb;
    }
    
    .pending-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: #fcd34d;
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 9999px;
        text-transform: uppercase;
    }
    
    .pending-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .btn-approve, .btn-reject {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-approve {
        background: #10b981;
        color: white;
        border: none;
    }
    
    .btn-approve:hover {
        background: #059669;
    }
    
    .btn-reject {
        background: white;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    
    .btn-reject:hover {
        background: #fee2e2;
    }
    
    .no-pending {
        color: #64748b;
        font-size: 0.9375rem;
        font-style: italic;
    }
</style>
@endsection


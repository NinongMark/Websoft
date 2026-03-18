@extends('layouts.app')

@section('title', 'PageTurner - Online Bookstore')

@section('content')
{{-- Hero Section --}}
<div class="hero">
    <h1 style="font-size: 2.25rem; font-weight: bold; margin-bottom: 1rem;">Welcome to PageTurner</h1>
    <p style="font-size: 1.25rem; margin-bottom: 1.5rem; color: #c7d2fe;">Discover your next favorite book from our extensive collection.</p>
    <a href="{{ route('books.index') }}" class="btn btn-white" style="display: inline-block; padding: 0.75rem 1.5rem; background: white; color: #4f46e5; border-radius: 0.5rem; text-decoration: none; font-weight: 600;">
        Browse Books
    </a>
</div>

{{-- Categories Section --}}
<section style="margin-bottom: 3rem;">
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Browse by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-4" style="gap: 1rem;">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; color: inherit; display: block; text-align: center; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                <h3 style="font-weight: 600; color: #1f2937;">{{ $category->name }}</h3>
                <p style="font-size: 0.875rem; color: #6b7280;">{{ $category->books_count }} books</p>
            </a>
        @endforeach
    </div>
</section>

{{-- Featured Books Section --}}
<section>
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Featured Books</h2>
    @if($featuredBooks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" style="gap: 1.5rem;">
            @foreach($featuredBooks as $book)
                <div class="book-card">
                    <div class="book-cover">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                        @else
                            <svg style="width: 5rem; height: 5rem; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="book-info">
                        <h3 style="font-weight: 600; font-size: 1rem; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $book->title }}</h3>
                        <p style="color: #4b5563; font-size: 0.875rem;">by {{ $book->author }}</p>
₱{{ number_format($book->price, 2) }}
                        
                        {{-- Star Rating --}}
                        <div class="rating" style="margin-top: 0.5rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($book->average_rating))
                                    <svg class="star star-filled" fill="currentColor" viewBox="0 0 20 20" style="width: 1rem; height: 1rem; color: #fbbf24;">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="star star-empty" fill="currentColor" viewBox="0 0 20 20" style="width: 1rem; height: 1rem; color: #d1d5db;">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span style="font-size: 0.875rem; color: #6b7280; margin-left: 0.25rem;">({{ $book->reviews->count() }})</span>
                        </div>
                        
                        <a href="{{ route('books.show', $book) }}" class="btn btn-primary" style="display: block; text-align: center; margin-top: 1rem; padding: 0.5rem; background: #4f46e5; color: white; border-radius: 0.25rem; text-decoration: none;">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            No books available at the moment. Check back soon!
        </div>
    @endif
</section>
@endsection


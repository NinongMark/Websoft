@extends('layouts.app')

@section('title', 'PageTurner - Online Bookstore')

@section('content')
{{-- Hero Section --}}
<div class="bg-indigo-900 text-white rounded-lg p-8 mb-8">
    <h1 class="text-4xl font-bold mb-4">Welcome to PageTurner</h1>
    <p class="text-xl text-indigo-300 mb-6">Discover your next favorite book from our extensive collection.</p>
    <a href="{{ route('books.index') }}" class="bg-indigo-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-600 transition">
        Browse Books
    </a>
</div>

{{-- Categories Section --}}
<section class="mb-12">
    <h2 class="text-2xl font-bold mb-6 text-white">Browse by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('categories.show', $category) }}" class="bg-gray-800 p-4 rounded-lg shadow hover:shadow-lg transition text-center border border-gray-700">
            <h3 class="font-semibold text-white">{{ $category->name }}</h3>
            <p class="text-sm text-gray-400">{{ $category->books_count }} books</p>
        </a>
        @endforeach
    </div>
</section>

{{-- Featured Books Section --}}
<section>
    <h2 class="text-2xl font-bold mb-6 text-white">Featured Books</h2>
    @forelse($featuredBooks as $book)
        @if($loop->first)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @endif
        <x-book-card :book="$book" />
        @if($loop->last)
        </div>
        @endif
    @empty
        <div class="bg-gray-800 border border-gray-700 text-gray-300 px-4 py-3 rounded relative">
            No books available at the moment. Check back soon!
        </div>
    @endforelse
</section>
@endsection

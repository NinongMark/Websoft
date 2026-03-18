@extends('layouts.app')

@section('title', $category->name . ' - PageTurner')

@section('header')
<div class="flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white">{{ $category->name }}</h1>
    @auth
    @if(auth()->user()->isAdmin())
    <div class="flex space-x-4">
        <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
            Edit Category
        </a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure? This will also delete all books in this category.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                Delete Category
            </button>
        </form>
    </div>
    @endif
    @endauth
</div>
@endsection

@section('content')
@if($category->description)
<div class="bg-gray-800 rounded-lg shadow p-6 mb-6 border border-gray-700">
    <p class="text-gray-300">{{ $category->description }}</p>
</div>
@endif

{{-- Books in this Category --}}
<h2 class="text-2xl font-bold mb-6 text-white">Books in {{ $category->name }}</h2>

@if($books->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($books as $book)
    <x-book-card :book="$book" />
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-8">
    {{ $books->links() }}
</div>
@else
<div class="bg-gray-800 border border-gray-700 text-gray-300 px-4 py-3 rounded relative">
    No books in this category yet.
</div>
@endif
@endsection


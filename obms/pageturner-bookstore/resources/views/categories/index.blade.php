@extends('layouts.app')

@section('title', 'Categories - PageTurner')

@section('header')
<h1 class="text-3xl font-bold text-white">All Categories</h1>
@endsection

@section('content')
{{-- Categories Grid --}}
@if($categories->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($categories as $category)
    <a href="{{ route('categories.show', $category) }}" class="bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-700">
        <h3 class="text-xl font-semibold text-white">{{ $category->name }}</h3>
        <p class="text-gray-400 mt-2">{{ $category->description }}</p>
        <p class="text-indigo-400 mt-4">{{ $category->books_count }} books</p>
    </a>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-8">
    {{ $categories->links() }}
</div>
@else
<div class="bg-gray-800 border border-gray-700 text-gray-300 px-4 py-3 rounded relative">
    No categories found.
</div>
@endif
@endsection


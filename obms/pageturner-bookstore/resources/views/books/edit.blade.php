@extends('layouts.app')

@section('title', 'Edit Book - PageTurner')

@section('header')
<h1 class="text-3xl font-bold text-white">Edit Book</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow p-6 border border-gray-700">
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-gray-300 font-medium mb-2">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" required>
                @error('title')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="author" class="block text-gray-300 font-medium mb-2">Author *</label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="category_id" class="block text-gray-300 font-medium mb-2">Category *</label>
                <select name="category_id" id="category_id" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="isbn" class="block text-gray-300 font-medium mb-2">ISBN *</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="price" class="block text-gray-300 font-medium mb-2">Price ($) *</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $book->price) }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="stock_quantity" class="block text-gray-300 font-medium mb-2">Stock Quantity *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $book->stock_quantity) }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $book->description) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="cover_image" class="block text-gray-300 font-medium mb-2">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm">
                @if($book->cover_image)
                <p class="text-sm text-gray-400 mt-2">Current: {{ $book->cover_image }}</p>
                @endif
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('books.show', $book) }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-500 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


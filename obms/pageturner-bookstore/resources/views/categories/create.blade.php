@extends('layouts.app')

@section('title', 'Add New Category - PageTurner')

@section('header')
<h1 class="text-3xl font-bold text-white">Add New Category</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-gray-800 rounded-lg shadow p-6 border border-gray-700">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-300 font-medium mb-2">Category Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" required>
                @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-500 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                    Add Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


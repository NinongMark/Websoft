@extends('layouts.app')

@section('title', 'Add New Book - PageTurner')

@section('header')
    <h1 style="font-size: 1.875rem; font-weight: bold; color: #111827;">Add New Book</h1>
@endsection

@section('content')
<div style="max-width: 42rem; margin: 0 auto;">
    <div class="card">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 1rem;">
                <label for="title" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
                @error('title')
                    <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="author" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Author *</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="category_id" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Category *</label>
                <select name="category_id" id="category_id" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label for="isbn" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">ISBN *</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
                </div>
                <div>
Price (₱) *
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
                </div>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="stock_quantity" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Stock Quantity *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;" required>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Description</label>
                <textarea name="description" id="description" rows="4" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;">{{ old('description') }}</textarea>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label for="cover_image" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #e5e7eb;">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #374151; color: #f3f4f6;">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('books.index') }}" class="btn btn-secondary" style="padding: 0.625rem 1.5rem; text-decoration: none;">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.625rem 1.5rem;">
                    Add Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


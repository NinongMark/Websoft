@extends('layouts.app')

@section('title', 'Add Category - PageTurner')

@section('header')
    <h1 style="font-size: 1.875rem; font-weight: bold; color: #111827;">Add New Category</h1>
@endsection

@section('content')
<div style="max-width: 42rem; margin: 0 auto;">
    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" required>
                @error('name')
                    <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">Description</label>
                <textarea name="description" id="description" rows="4" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('description') }}</textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary" style="padding: 0.625rem 1.5rem; text-decoration: none;">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.625rem 1.5rem;">
                    Add Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


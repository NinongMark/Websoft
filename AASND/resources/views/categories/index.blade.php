@extends('layouts.app')

@section('title', 'Categories - PageTurner')

@section('header')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.875rem; font-weight: bold; color: #111827;">Categories</h1>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="padding: 0.625rem 1.5rem; text-decoration: none;">
                    Add Category
                </a>
            @endif
        @endauth
    </div>
@endsection

@section('content')
@if($categories->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3" style="gap: 1.5rem;">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="card" style="text-decoration: none; color: inherit; display: block; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                <h3 style="font-weight: 600; font-size: 1.25rem; color: #1f2937;">{{ $category->name }}</h3>
                <p style="color: #6b7280; margin-top: 0.5rem;">{{ $category->books_count }} books</p>
                @if($category->description)
                    <p style="color: #4b5563; margin-top: 0.75rem; font-size: 0.875rem;">{{ Str::limit($category->description, 100) }}</p>
                @endif
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.categories.edit', $category) }}" style="color: #f59e0b; font-size: 0.875rem;">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.875rem;">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </a>
        @endforeach
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $categories->links() }}
    </div>
@else
    <div class="alert alert-info">
        No categories available yet.
    </div>
@endif
@endsection


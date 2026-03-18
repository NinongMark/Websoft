@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Tasks</h2>
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    <a href="/tasks/create" class="btn">Add New Task</a>
    <ul class="task-list">
        @forelse($tasks as $task)
            <li class="task-item">
                <span>{{ $task->title }}</span>
                <div class="task-actions">
                    <a href="/tasks/{{ $task->id }}/edit" class="btn edit">Edit</a>
                    <form method="POST" action="/tasks/{{ $task->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <p>No tasks yet. <a href="/tasks/create">Create one</a></p>
        @endforelse
    </ul>
    <p><a href="/profile">Go to Profile</a> | <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></p>
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>
</div>
@endsection

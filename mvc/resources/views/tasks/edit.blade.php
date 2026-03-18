@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h2>Edit Task</h2>
        <form method="POST" action="/tasks/{{ $task->id }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Task Title</label>
                <input type="text" id="title" name="title" value="{{ $task->title }}" required>
            </div>
            <button type="submit" class="btn">Update Task</button>
        </form>
        <p><a href="/tasks">Back to Tasks</a></p>
    </div>
</div>
@endsection

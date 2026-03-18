@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h2>Create New Task</h2>
        <form method="POST" action="/tasks">
            @csrf
            <div class="form-group">
                <label for="title">Task Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <button type="submit" class="btn">Create Task</button>
        </form>
        <p><a href="/tasks">Back to Tasks</a></p>
    </div>
</div>
@endsection

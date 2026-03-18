@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h2>Profile</h2>
        <form method="POST" action="/profile">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $user->name ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
        <p><a href="/tasks">Back to Tasks</a></p>
    </div>
</div>
@endsection

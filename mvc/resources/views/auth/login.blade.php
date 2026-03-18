@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="/register">Register here</a></p>
    </div>
</div>
@endsection

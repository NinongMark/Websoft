@extends('layouts.app')

@section('title', 'Verify Email - PageTurner')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Verify Your Email Address</h2>
        
        <div class="mb-6">
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    A new verification link has been sent to your email address.
                </div>
            @endif
        </div>

        <p class="text-gray-600 text-center mb-6">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
                Resend Verification Email
            </button>
        </form>

        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-indigo-600 hover:text-indigo-700">
                    Log Out
                </button>
            </form>
        </div>
</div>
@endsection

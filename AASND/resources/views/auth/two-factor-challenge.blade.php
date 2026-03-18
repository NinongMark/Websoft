@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Two-Factor Authentication') }}</div>

                <div class="card-body">
<p class="mb-4">Check your email for the 6-digit verification code.</p>

                    @if (session('status') == 'code-sent')
                        <div class="alert alert-success">
                            Code sent to your email!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('two-factor.verify') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="code" class="form-label">{{ __('Verification Code') }}</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="off" autofocus maxlength="6" placeholder="Enter 6-digit code">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Wrong Code, Please re-enter Code</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>

                    <hr>

                    <form method="POST" action="{{ route('two-factor.resend') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none">
                            <i class="fas fa-redo"></i> Resend Code
                        </button>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p class="text-muted mb-2">Lost access to your device?</p>
                        <p class="small">Use one of your recovery codes to access your account.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


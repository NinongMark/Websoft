@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Setup Two-Factor Authentication') }}</div>

                <div class="card-body">
                    <p class="mb-4">Scan the QR code below with your authenticator app (such as Google Authenticator or Authy).</p>
                    
                    <div class="text-center mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" alt="QR Code" class="img-fluid">
                    </div>

                    <div class="alert alert-info">
                        <strong>Manual Entry Code:</strong> {{ $secret }}
                    </div>

                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="code" class="form-label">{{ __('Verification Code') }}</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="off" autofocus placeholder="Enter 6-digit code">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">Enter the 6-digit code from your authenticator app</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Enable Two-Factor Authentication') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


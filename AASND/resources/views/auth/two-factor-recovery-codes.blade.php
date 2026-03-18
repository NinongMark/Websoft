@extends('layouts.app')

@section('title', 'Recovery Codes - Two-Factor Authentication')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Recovery Codes') }}</span>
                        <form method="POST" action="{{ route('two-factor.regenerate-codes') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                {{ __('Regenerate Codes') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Important:</strong> Store these recovery codes in a secure location. Each code can only be used once.
                    </div>

                    <div class="row">
                        @foreach($recoveryCodes as $code)
                        <div class="col-md-6 mb-2">
                            <code class="p-2 bg-light rounded d-block text-center">{{ $code }}</code>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            {{ __('Back to Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


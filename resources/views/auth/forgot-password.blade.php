@extends('layouts.auth')

@section('title', 'Reset password — Aura Studio')

@section('content')
    <div class="sketch-wrap">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" stroke="var(--text-main)" stroke-width="1.5" stroke-linecap="round">
            <path d="M10 30 C10 15, 20 10, 30 10 C40 10, 50 15, 50 30 C50 45, 40 50, 30 50 C20 50, 10 45, 10 30" />
            <path d="M30 20 V35" stroke-dasharray="2 2" />
            <circle cx="30" cy="40" r="1.5" fill="var(--text-main)" />
            <path d="M22 25 C25 20, 35 20, 38 25" fill="var(--accent-sage)" fill-opacity="0.1" />
        </svg>
    </div>
    <h1>Reset password</h1>
    <p style="margin-bottom: 32px;">Enter your email and we'll send instructions to reset your password.</p>

    {{-- Session Status --}}
    @if (session('status'))
        <div style="background: #E2EAE3; color: #4A7052; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@email.com" required>
            @error('email')
                <span style="color: var(--accent-terracotta); font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-submit">Send reset link</button>
    </form>

    <p style="margin-top: 32px; text-align: center; font-size: 14px;">
        <a href="{{ route('login') }}" class="text-link"><i class="iconoir-arrow-left" style="font-size: 12px; margin-right: 4px;"></i> Back to login</a>
    </p>
@endsection
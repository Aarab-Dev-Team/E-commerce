@extends('layouts.auth')

@section('title', 'Reset password — Aura Studio')

@section('content')
    <div class="sketch-wrap">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" stroke="var(--text-main)" stroke-width="1.5" stroke-linecap="round">
            <path d="M30 10 C15 10, 10 20, 10 30 C10 45, 20 50, 30 50 C45 50, 50 40, 50 30 C50 15, 40 10, 30 10" />
            <circle cx="30" cy="25" r="7" fill="var(--accent-sage)" fill-opacity="0.1" />
            <path d="M18 45 C22 38, 38 38, 42 45" />
        </svg>
    </div>
    <h1>Reset password</h1>
    <p style="margin-bottom: 32px;">Please enter your new password.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- Password Reset Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" readonly required>
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password">New password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span style="color: var(--accent-terracotta); font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-submit">Reset password</button>
    </form>
@endsection
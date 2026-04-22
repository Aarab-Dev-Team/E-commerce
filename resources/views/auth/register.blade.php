@extends('layouts.auth')

@section('title', 'Create account — Aura Studio')

@section('content')
    <h1>Create account</h1>
    <p style="margin-bottom: 32px;">Join our community of mindful curators.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="form-group">
            <label for="name">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Arlo Jensen" required>
            @error('name')
                <span style="color: red; font-weight: 500; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@email.com" required>
            @error('email')
                <span style="color: red; font-weight: 500; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Min. 8 characters" required>
            @error('password')
                <span style="color: red; font-weight: 500; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-enter password" required>
        </div>

        <label class="checkbox-container" style="margin-bottom: 24px;">
            <input type="checkbox" name="terms">
            <div class="custom-check"></div>
            <span style="line-height: 1.4;">I agree to the <a href="#" class="text-link">Terms of Service</a> and <a href="#" class="text-link">Privacy Policy</a></span>
        </label>
        @error('terms')
            <p style="color:red; font-size: 12px; font-weight: 500;">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn-submit">Create account</button>
    </form>

    <p style="margin-top: 32px; text-align: center; font-size: 14px;">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-link" style="font-weight: 500;">Sign in</a>
    </p>
@endsection
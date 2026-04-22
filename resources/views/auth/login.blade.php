@extends('layouts.auth')

@section('title', 'Sign in — Aura Studio')

@section('content')
    <div class="sketch-wrap">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" stroke="var(--text-main)" stroke-width="1.5" stroke-linecap="round">
            <path d="M30 10 C15 10, 10 20, 10 30 C10 45, 20 50, 30 50 C45 50, 50 40, 50 30 C50 15, 40 10, 30 10" />
            <circle cx="30" cy="25" r="7" fill="var(--accent-sage)" fill-opacity="0.1" />
            <path d="M18 45 C22 38, 38 38, 42 45" />
        </svg>
    </div>
    <h1>Welcome back</h1>
    <p style="margin-bottom: 32px;">Please enter your details to access your studio account.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@email.com" required autofocus>
            @error('email')
                <span style="color: red; font-weight: 500; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <div class="flex-between">
                <label for="password" style="margin-bottom: 0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-link">Forgot password?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
            <i class="iconoir-eye-empty input-icon" onclick="togglePassword(this)"></i>
            @error('password')
                <span style="color: red; font-weight: 500; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Remember Me --}}
        <label class="checkbox-container" style="margin-bottom: 24px;">
            <input type="checkbox" name="remember">
            <div class="custom-check"></div>
            <span>Keep me signed in</span>
        </label>

        <button type="submit" class="btn-submit">Sign in</button>
    </form>

    <div class="divider"><span>or continue with</span></div>
    
    <button class="btn-ghost"><i class="iconoir-google"></i> Google</button>

    <p style="margin-top: 32px; text-align: center; font-size: 14px;">
        New to Aura? 
        <a href="{{ route('register') }}" class="text-link" style="font-weight: 500;">Create an account</a>
    </p>
@endsection

@push('scripts')
<script>
    function togglePassword(icon) {
        let input = icon.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('iconoir-eye-empty');
            icon.classList.add('iconoir-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('iconoir-eye-off');
            icon.classList.add('iconoir-eye-empty');
        }
    }
</script>
@endpush
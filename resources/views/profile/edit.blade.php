@extends('layouts.profile')

@section('title', 'Your Profile — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-edit.css'])
@endpush

@section('profile-content')
    <div class="page-title">
        <h1>Profile information</h1>
        <p>Update your photo and personal details here.</p>
    </div>

    {{-- Success Messages --}}
    @if(session('success'))
        <div style="background: var(--alert-success-bg, #E2EAE3); color: var(--alert-success-text, #4A7052); border: 1px solid var(--alert-success-border, #B8D1BE); padding: 14px 16px; border-radius: 4px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Personal Details Card --}}
    <section class="profile-card">
        <div class="profile-card-header">
            <h2>Personal details</h2>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="avatar-upload">
                <div class="avatar-large">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                        <i class="iconoir-user" style="font-size: 32px; opacity: 0.3;"></i>
                    @endif
                </div>
                <div>
                    <button type="button" class="btn btn-ghost" style="padding: 8px 16px; font-size: 0.875rem;">Change picture</button>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name') <span style="color: var(--accent-clay); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+1 (555) 000-0000">
                    @error('phone') <span style="color: var(--accent-clay); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email') <span style="color: var(--accent-clay); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('profile.edit') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </section>

    {{-- Security Card --}}
    <section class="profile-card">
        <div class="profile-card-header">
            <h2>Security</h2>
            <p>Make sure your account stays safe.</p>
        </div>

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Current password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="••••••••" required>
                @error('current_password') <span style="color: var(--accent-clay); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">New password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password') <span style="color: var(--accent-clay); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm new password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update password</button>
            </div>
        </form>
    </section>


    @auth 

        @if(auth()->user()->role==="customer")
            {{-- Saved Addresses Card --}}
            <section class="profile-card">
                <div class="profile-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2>Saved addresses</h2>
                        <p>Where we send your orders.</p>
                    </div>
                    <a href="{{ route("profile.addresses.index") }}" class="btn btn-ghost" style="padding: 8px 16px; font-size: 0.875rem;"><i class="iconoir-plus"></i> Add new</a href="">
                </div>

                <div class="address-grid">
                    @forelse(auth()->user()->addresses as $address)
                           <a href="{{ route("profile.addresses.index") }}">
                        <div class="address-card">
                            <h3>{{ $address->type === 'shipping' ? 'Shipping' : 'Billing' }}</h3>
                            <p>{{ $address->address_line_1 }}</p>
                            @if($address->address_line_2)<p>{{ $address->address_line_2 }}</p>@endif
                            <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                            <p>{{ $address->country }}</p>
                           
                        </div>
                        </a>
                    @empty
                        <p>No saved addresses yet.</p>
                    @endforelse
                </div>
            </section>

        @endif
    @endauth

    {{-- Danger Zone --}}
    <section class="profile-card danger-zone">
        <div class="profile-card-header">
            <h2>Delete account</h2>
            <p>This action is final. You cannot get your data back.</p>
        </div>

        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label for="delete_password">Enter your password to confirm</label>
                <input type="password" name="password" id="delete_password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete my account</button>
        </form>
    </section>
@endsection
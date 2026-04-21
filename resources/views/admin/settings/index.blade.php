@extends('layouts.admin')

@section('title', 'Settings — Aura. Admin')

@section('page-title', 'Settings')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>Preferences</h1>
            <p>Global configuration for the Aura storefront.</p>
        </div>
        <button type="submit" form="settingsForm" class="btn btn-primary">Save changes</button>
    </div>

    @if(session('success'))
        <div style="background: var(--accent-sage); color: white; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="max-width: 680px;">
        <form id="settingsForm" method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            <h3 style="margin-bottom: 24px;">General</h3>
            <div class="form-group">
                <label>Store Name</label>
                <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required>
            </div>
            <div class="form-group">
                <label>Contact Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
            </div>

            <div class="nav-divider" style="margin: 32px 0;"></div>

            <h3 style="margin-bottom: 24px;">Regional</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Base Currency</label>
                    <select name="currency">
                        <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ $settings['currency'] == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Timezone</label>
                    <select name="timezone">
                        <option value="PT" {{ $settings['timezone'] == 'PT' ? 'selected' : '' }}>Pacific Time (PT)</option>
                        <option value="ET" {{ $settings['timezone'] == 'ET' ? 'selected' : '' }}>Eastern Time (ET)</option>
                        <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>Coordinated Universal Time (UTC)</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
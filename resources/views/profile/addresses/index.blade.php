@extends('layouts.profile')

@section('title', 'Saved Addresses — Aura Studio')

@push('styles')
    @vite(['resources/css/profile-addresses.css'])
@endpush

@section('profile-content')
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flash-message success" id="flash-message">
            <i class="iconoir-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="page-header">
        <div>
            <h1>Saved addresses</h1>
            <p>Manage your shipping and billing addresses.</p>
        </div>
        <button class="btn-filled" id="openModalBtn">
            <i class="iconoir-plus"></i> Add new address
        </button>
    </div>

    @if($addresses->isEmpty())
        <div class="empty-state">
            <i class="iconoir-map-pin"></i>
            <p>No saved addresses yet.</p>
            <button class="btn-ghost" id="emptyAddBtn">Add your first address</button>
        </div>
    @else
        <div class="address-grid">
            @foreach($addresses as $address)
                <div class="address-card">
                    <div class="card-header">
                        <div class="badges">
                            @if($address->is_default)
                                <span class="badge badge-default">Default</span>
                            @endif
                            <span class="badge badge-type">
                                {{ $address->type === 'both' ? 'Shipping & Billing' : ucfirst($address->type) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <strong>{{ $address->full_name }}</strong>
                        {{ $address->address_line_1 }}<br>
                        @if($address->address_line_2){{ $address->address_line_2 }}<br>@endif
                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                        {{ $address->country }}<br>
                        @if($address->phone){{ $address->phone }}@endif
                    </div>
                    <div class="card-actions">
                        <span class="action-link edit-btn" data-address="{{ json_encode($address) }}">
                            <i class="iconoir-edit-pencil"></i> Edit
                        </span>
                        <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link danger" style="background:none; border:none; padding:0;">
                                <i class="iconoir-trash"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Modal --}}
    @include('profile.addresses.partials.modal')
@endsection

@push('scripts')
<script>
    // Pass edit addresses data to JavaScript
    window.addresses = @json($addresses);
</script>
@vite(['resources/js/profile-addresses.js'])
@endpush
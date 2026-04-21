@extends('layouts.admin')

@section('title', 'Users — Aura. Admin')

@section('page-title', 'Users')

@section('content')
<div class="page">
    <div class="section-header">
        <div>
            <h1>User directory</h1>
            <p>Manage access levels, customers, and team members.</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: var(--accent-sage); color: white; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: var(--accent-terracotta); color: white; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="filters-bar">
        <div style="flex-grow: 1; max-width: 320px;">
            <label>Search</label>
            <div class="search-container" style="width: 100%;">
                <i class="iconoir-search"></i>
                <input type="text" name="search" placeholder="Name or email address..." value="{{ request('search') }}">
            </div>
        </div>
        <div style="width: 200px;">
            <label>Filter by role</label>
            <select name="role" onchange="this.form.submit()">
                <option value="">All roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-ghost">Filter</button>
        @if(request()->anyFilled(['search', 'role']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Clear</a>
        @endif
    </form>

    {{-- Users Table --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered</th>
                    <th>Update Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="role-form">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="table-select" onchange="this.form.submit()" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                            @if($user->id === auth()->id())
                                <small style="color: var(--text-secondary);">(you)</small>
                            @endif
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination">
        {{ $users->links('pagination.admin') }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Confirm role change for admins (prevent accidental demotion)
    document.querySelectorAll('.role-form').forEach(form => {
        form.addEventListener('submit', (e) => {
            const select = form.querySelector('select');
            const currentRole = select.getAttribute('data-current') || '{{ auth()->user()->role }}';
            const newRole = select.value;
            const isSelf = select.disabled;

            if (!isSelf && newRole !== currentRole) {
                if (newRole === 'admin' || confirm(`Change role to ${newRole}?`)) {
                    // proceed
                } else {
                    e.preventDefault();
                }
            }
        });
    });
</script>
@endpush
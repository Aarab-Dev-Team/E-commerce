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



    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="admin-filter-form">
        <div class="search-boxed" style="width: 320px;">
            <i class="iconoir-search"></i>
            <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
        </div>

        <select name="role" onchange="this.form.submit()" class="input-styled" style="width: 200px;">
            <option value="">All roles</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
        </select>

        <button type="submit" class="btn-ghost">Filter</button>
        @if(request()->anyFilled(['search', 'role']))
            <a href="{{ route('admin.users.index') }}" class="btn-ghost" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">Clear</a>
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
                            <select name="role" class="table-select" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                @if($user->role === 'admin')
                                    <option value="admin" selected>Admin</option>
                                @endif
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
        {{ $users->links('pagination.custom') }}
    </div>
</div>
{{-- Password Confirmation Modal --}}
<style>
/* Editorial Modal Styles */
.custom-modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.custom-modal-overlay.active {
    display: flex;
    opacity: 1;
}
.custom-modal {
    background: var(--surface-primary, #ffffff);
    padding: 32px;
    border-radius: var(--radius-sm);
    width: 100%;
    max-width: 400px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    transform: translateY(20px);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.custom-modal-overlay.active .custom-modal {
    transform: translateY(0);
}
.custom-modal h3 {
    margin-top: 0;
    margin-bottom: 8px;
    font-size: 1.25rem;
    font-weight: 500;
    color: var(--text-primary, #1a1a1a);
}
.custom-modal p {
    margin-bottom: 24px;
    font-size: 0.95rem;
    color: var(--text-secondary, #666666);
    line-height: 1.5;
}
.custom-modal .input-styled {
    width: 100%;
    margin-bottom: 24px;
    box-sizing: border-box;
}
.custom-modal .modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
</style>

<div class="custom-modal-overlay" id="passwordModal">
    <div class="custom-modal">
        <h3>Confirm Role Change</h3>
        <p>Please enter your admin password to authorize changing this user's role to <strong id="modalRoleName"></strong>.</p>
        <input type="password" id="modalPasswordInput" class="input-styled" placeholder="Admin password">
        <div class="modal-actions">
            <button type="button" class="btn-ghost" id="modalCancelBtn" style="height: 40px ; width:100px">Cancel</button>
            <button type="button" class="btn-primary" style="height: 40px ; width:100px" id="modalConfirmBtn">Confirm</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.role-form').forEach(form => {
        const select = form.querySelector('select');
        let previousValue = select.value;

        select.addEventListener('change', (e) => {
            const newRole = select.value;
            const isSelf = select.disabled;

            if (!isSelf && newRole !== previousValue) {
                const modalOverlay = document.getElementById('passwordModal');
                const roleNameEl = document.getElementById('modalRoleName');
                const passInput = document.getElementById('modalPasswordInput');
                const cancelBtn = document.getElementById('modalCancelBtn');
                const confirmBtn = document.getElementById('modalConfirmBtn');
                
                roleNameEl.textContent = newRole;
                passInput.value = '';
                passInput.style.border = ''; // reset error border if any
                
                // Show modal
                modalOverlay.classList.add('active');
                setTimeout(() => passInput.focus(), 100); // Wait for transition

                const closeModal = () => {
                    modalOverlay.classList.remove('active');
                    confirmBtn.removeEventListener('click', handleConfirm);
                    cancelBtn.removeEventListener('click', handleCancel);
                };

                const handleConfirm = () => {
                    const password = passInput.value;
                    if (password) {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'admin_password';
                        input.value = password;
                        form.appendChild(input);
                        closeModal();
                        form.submit();
                    } else {
                        passInput.style.border = '1px solid var(--accent-terracotta, red)';
                    }
                };

                const handleCancel = () => {
                    select.value = previousValue;
                    closeModal();
                };

                confirmBtn.addEventListener('click', handleConfirm);
                cancelBtn.addEventListener('click', handleCancel);
                
                // Allow enter key in input to confirm
                passInput.addEventListener('keypress', function onEnter(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        handleConfirm();
                        passInput.removeEventListener('keypress', onEnter);
                    }
                });
            }
        });
    });
</script>
@endpush
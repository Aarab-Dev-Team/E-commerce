<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aura. Admin')</title>

    {{-- Typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Icons (Iconoir) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css">

    {{-- Admin Styles --}}
    @vite(['resources/css/admin.css'])
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">Aura.</a>

        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                    <i class="iconoir-app-window"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                    <i class="iconoir-box-iso"></i>
                    Products
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                    <i class="iconoir-delivery-truck"></i>
                    Orders
                </a>
            </li>

            

            {{-- Admin-only links (will be wrapped with @can later) --}}
            @if(auth()->user()->role === 'admin')
                <div class="nav-divider"></div>
                <li class="nav-item {{ request()->routeIs('admin.approvals.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.approvals.index') }}"><i class="iconoir-bell"></i> Approvals</a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}"><i class="iconoir-folder"></i> Categories</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupons.index') }}"><i class="iconoir-ticket"></i> Coupons</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}"><i class="iconoir-group"></i> Users</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"><i class="iconoir-settings"></i> Settings</a>
                </li>
            @endif

            
        </ul>

        <div class="sidebar-footer">
            <p>{{ auth()->user()->name }}</p>
            <p>{{ auth()->user()->email }}</p>
            <br>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0; color: var(--text-secondary); cursor: pointer; text-decoration: underline;">Sign out</button>
            </form>
        </div>
    </aside>

    {{-- Main Content Wrapper --}}
    <div class="main-wrapper">

        {{-- Top Bar --}}
        <header class="top-bar">
            <div  style="display:flex ; justify-content:space-between; align-items:center ; padding : 10px 64px">
                <div class="page-title-display">@yield('page-title', 'Overview')</div>

                <div class="top-actions">
                
                    <div class="user-menu">
                        <a href="{{ route('profile.edit') }}">
                        <i class="iconoir-user"></i>
                        </a>
                    </div>
                </div>
            </div>

            
             {{-- Alert Container --}}
            @if(session('alert'))
                <div >
                    <x-alert :type="session('alert')['type']" 
                            :message="session('alert')['message']" 
                            :icon="session('alert')['icon'] ?? null" />
                </div>
            @endif
 
        </header>

        

        {{-- Dynamic Content Area --}}
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    {{-- Modals can be placed here or included via @stack --}}
    @stack('modals')

    {{-- Scripts --}}
    <script>
        // Global functions for modals (can be overridden)
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }
        // Close modal on background click
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        overlay.classList.remove('active');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
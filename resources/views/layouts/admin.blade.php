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

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="sidebar">

        <a href="{{ url('/') }}" class="logo">
            <span class="aura-text">Aura</span><span class="dot">◼</span>
        </a>
            

        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                    <?xml version="1.0" encoding="UTF-8"?>
                    <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M13.9922 17H16.9922H19.9922" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M4 9.4V4.6C4 4.26863 4.26863 4 4.6 4H9.4C9.73137 4 10 4.26863 10 4.6V9.4C10 9.73137 9.73137 10 9.4 10H4.6C4.26863 10 4 9.73137 4 9.4Z" stroke="#000000" stroke-width="1.5"></path><path d="M4 19.4V14.6C4 14.2686 4.26863 14 4.6 14H9.4C9.73137 14 10 14.2686 10 14.6V19.4C10 19.7314 9.73137 20 9.4 20H4.6C4.26863 20 4 19.7314 4 19.4Z" stroke="#000000" stroke-width="1.5"></path><path d="M14 9.4V4.6C14 4.26863 14.2686 4 14.6 4H19.4C19.7314 4 20 4.26863 20 4.6V9.4C20 9.73137 19.7314 10 19.4 10H14.6C14.2686 10 14 9.73137 14 9.4Z" stroke="#000000" stroke-width="1.5"></path></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                    <?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M21 7.35304L21 16.647C21 16.8649 20.8819 17.0656 20.6914 17.1715L12.2914 21.8381C12.1102 21.9388 11.8898 21.9388 11.7086 21.8381L3.30861 17.1715C3.11814 17.0656 3 16.8649 3 16.647L2.99998 7.35304C2.99998 7.13514 3.11812 6.93437 3.3086 6.82855L11.7086 2.16188C11.8898 2.06121 12.1102 2.06121 12.2914 2.16188L20.6914 6.82855C20.8818 6.93437 21 7.13514 21 7.35304Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3.52844 7.29357L11.7086 11.8381C11.8898 11.9388 12.1102 11.9388 12.2914 11.8381L20.5 7.27777" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 21L12 12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    Products
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; gap: 12px; width: 100%;">
                   <?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="#000000" stroke-width="1.5" stroke-miterlimit="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 19C19.1046 19 20 18.1046 20 17C20 15.8954 19.1046 15 18 15C16.8954 15 16 15.8954 16 17C16 18.1046 16.8954 19 18 19Z" stroke="#000000" stroke-width="1.5" stroke-miterlimit="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.05 17H15V6.6C15 6.26863 14.7314 6 14.4 6H1" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path><path d="M5.65 17H3.6C3.26863 17 3 16.7314 3 16.4V11.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path><path d="M2 9L6 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15 9H20.6101C20.8472 9 21.0621 9.13964 21.1584 9.35632L22.9483 13.3836C22.9824 13.4604 23 13.5434 23 13.6273V16.4C23 16.7314 22.7314 17 22.4 17H20.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path><path d="M15 17H16" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path></svg>
                    Orders
                </a>
            </li>

            

            {{-- Admin-only links (will be wrapped with @can later) --}}
            @if(auth()->user()->role === 'admin')
                <div class="nav-divider"></div>
                <li class="nav-item {{ request()->routeIs('admin.approvals.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.approvals.index') }}"  style="display: flex; align-items: center; gap: 12px; width: 100%;"
                    ><?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M2.99997 7V4C2.99997 3.44772 3.44769 3 3.99997 3H20.0001C20.5523 3 21 3.44766 21.0001 3.9999L21.0004 7M2.99997 7L9.65077 12.7007C9.87241 12.8907 9.99998 13.168 9.99998 13.4599V19.7192C9.99998 20.3698 10.6114 20.8472 11.2425 20.6894L13.2425 20.1894C13.6877 20.0781 14 19.6781 14 19.2192V13.46C14 13.168 14.1275 12.8907 14.3492 12.7007L21.0004 7M2.99997 7H21.0004" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Approvals</a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}"  style="display: flex; align-items: center; gap: 12px; width: 100%;"
                    ><?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M2.6 4H8.77805C8.92127 4 9.05977 4.05124 9.16852 4.14445L12.3315 6.85555C12.4402 6.94876 12.5787 7 12.722 7H21.4C21.7314 7 22 7.26863 22 7.6V10.4C22 10.7314 21.7314 11 21.4 11H2.6C2.26863 11 2 10.7314 2 10.4V4.6C2 4.26863 2.26863 4 2.6 4Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22 10L22 14" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M2 10V19.4C2 19.7314 2.26863 20 2.6 20H13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19 21C20.1046 21 21 20.1046 21 19C21 17.8954 20.1046 17 19 17C18.6357 17 18.2942 17.0974 18 17.2676C17.4022 17.6134 17 18.2597 17 19C17 19.7403 17.4022 20.3866 18 20.7324C18.2942 20.9026 18.6357 21 19 21Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19 22C20.6569 22 22 20.6569 22 19C22 17.3431 20.6569 16 19 16C17.3431 16 16 17.3431 16 19C16 20.6569 17.3431 22 19 22Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="0.3 2"></path></svg> Categories</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupons.index') }}"  style="display: flex; align-items: center; gap: 12px; width: 100%;"
                    ><?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6 3H3V6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 3H21V6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 21H3V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 21H21V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12.5145 17.6913L16.5145 15.2913C16.8157 15.1106 17 14.7851 17 14.4338V10.5662C17 10.2149 16.8157 9.88942 16.5145 9.7087L12.5145 7.3087C12.1978 7.11869 11.8022 7.11869 11.4855 7.3087L7.4855 9.7087C7.1843 9.88942 7 10.2149 7 10.5662V14.4338C7 14.7851 7.1843 15.1106 7.4855 15.2913L11.4855 17.6913C11.8022 17.8813 12.1978 17.8813 12.5145 17.6913Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.5 10.5L12 12.9995M12 12.9995C12 12.9995 15.7637 10.9492 16.5 10.5M12 12.9995V17.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Coupons</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}"  style="display: flex; align-items: center; gap: 12px; width: 100%;"
                    ><?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M6 3H3V6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 3H21V6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6 21H3V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7 18V17C7 14.2386 9.23858 12 12 12V12C14.7614 12 17 14.2386 17 17V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18 21H21V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Users</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"  style="display: flex; align-items: center; gap: 12px; width: 100%;"
                    ><?xml version="1.0" encoding="UTF-8"?><svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19.6224 10.3954L18.5247 7.7448L20 6L18 4L16.2647 5.48295L13.5578 4.36974L12.9353 2H10.981L10.3491 4.40113L7.70441 5.51596L6 4L4 6L5.45337 7.78885L4.3725 10.4463L2 11V13L4.40111 13.6555L5.51575 16.2997L4 18L6 20L7.79116 18.5403L10.397 19.6123L11 22H13L13.6045 19.6132L16.2551 18.5155C16.6969 18.8313 18 20 18 20L20 18L18.5159 16.2494L19.6139 13.598L21.9999 12.9772L22 11L19.6224 10.3954Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Settings</a>
                </li>
            @endif

            
        </ul>

        <div class="sidebar-footer">
            <div class="sidebar-user-info">
                <span class="sidebar-user-label">Logged in as</span>
                <p class="sidebar-user-name">
                    {{ auth()->user()->name }}
                    <span class="badge badge-{{ auth()->user()->role }}" style="margin-left: 8px; font-size: 9px; vertical-align: middle;">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </p>
                <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Wrapper --}}
    <div class="main-wrapper">

        {{-- Top Bar --}}
        <header class="top-bar">
            <div class="top-bar-content">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="mobile-toggle" id="sidebarToggle">
                        <i class="iconoir-menu"></i>
                    </button>
                    <div class="page-title-display">@yield('page-title', 'Overview')</div>
                </div>

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

        // Sidebar Toggle for Mobile
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // Close modal on background click
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
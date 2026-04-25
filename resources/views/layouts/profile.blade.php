<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Your Profile — Aura Studio')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    
    {{-- Iconoir Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css">

    {{-- Core CSS Variables and Reset (matches profile.html) --}}
    <style>
        :root {
            --bg-color: #F5F4F0;
            --surface-color: #FFFFFF;
            --text-main: #1A1A18;
            --text-secondary: #6B6A66;
            --border-color: #E8E6E0;
            --accent-clay: #F04A20;       
            --accent-sage: #4E8C5A;       
            --accent-sand: #C4A06A;        
            --font-primary: 'DM Sans', sans-serif;
            --transition-speed: 150ms;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            text-decoration: none  ; 
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-primary);
            font-weight: 400;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4 {
            font-weight: 400;
            letter-spacing: -0.02em;
            line-height: 1.15;
            color: var(--text-main);
        }

        h1 { font-size: 3rem; margin-bottom: 0.5rem; }
        h2 { font-size: 1.75rem; margin-bottom: 1.5rem; }
        h3 { font-size: 1.15rem; font-weight: 500; }

        p { color: var(--text-secondary); font-size: 1rem; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── Header ───────────────────────────────────────── */
        .profile-header {
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 64px;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0;
        }

        .logo > * {
        font-size: 24px;
        font-weight: 500;
        letter-spacing: -0.04em;
        }

        .aura-text {
            color: var(--accent-clay);
        }

        .dot {
            color: black;     
            font-size: 10px;    
            margin: 0 1px
        }



        .header-nav {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .header-nav a {
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 1rem;
            white-space: nowrap;
        }

        .header-nav a:hover {
            color: var(--text-secondary);
        }

        /* Force-hide mobile drawer on large screens (even if .open class is present) */
        @media (min-width: 901px) {
            .mobile-nav-drawer,
            .mobile-nav-drawer.open {
                display: none !important;
            }
        }

        /* Hamburger (hidden on desktop) */
        .nav-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 8px 10px;
            cursor: pointer;
            color: var(--text-main);
            font-size: 1.25rem;
            line-height: 1;
            transition: var(--transition-speed);
        }
        .nav-toggle:hover { background: var(--surface-color); }

        /* Mobile drawer */
        .mobile-nav-drawer {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding: 16px 0 24px;
            border-top: 1px solid var(--border-color);
        }
        .mobile-nav-drawer.open { display: flex; }
        .mobile-nav-drawer a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 8px;
            text-decoration: none;
            color: var(--text-main);
            border-radius: 4px;
            font-size: 0.95rem;
            transition: var(--transition-speed);
        }
        .mobile-nav-drawer a:hover { background: var(--surface-color); }

        /* ── Profile Layout (Sidebar + Content) ───────────── */
        .profile-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 56px;
            margin-bottom: 100px;
        }

        /* Sidebar */
        .profile-sidebar {
            position: sticky;
            top: 32px;
            height: fit-content;
        }

        .user-info-small {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 40px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .avatar-small {
            width: 48px;
            height: 48px;
            border-radius: 4px;
            background: var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu a,
        .sidebar-menu button.sidebar-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            text-decoration: none;
            color: var(--text-secondary);
            border-radius: 4px;
            transition: var(--transition-speed);
            font-size: 0.9375rem;
            width: 100%;
            background: none;
            border: none;
            font-family: inherit;
            cursor: pointer;
            text-align: left;
        }

        .sidebar-menu a:hover,
        .sidebar-menu button.sidebar-btn:hover {
            background: var(--surface-color);
            color: var(--text-main);
        }

        .sidebar-menu a.active {
            background: var(--surface-color);
            color: var(--text-main);
            font-weight: 500;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .sidebar-menu i { font-size: 1.2rem; }

        /* Main Content Area */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 40px;
            min-width: 0; /* prevent overflow in grid */
        }

        /* ── Footer ───────────────────────────────────────── */
        .profile-footer {
            border-top: 1px solid var(--border-color);
            padding: 32px 0 64px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
            gap: 16px;
            flex-wrap: wrap;
           
        }

        .footer-links {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            white-space: nowrap;
        }

        .footer-links a:hover { color: var(--text-main); }



        /* ── Responsive: Tablet (≤ 900px) ─────────────────── */
        @media (max-width: 900px) {
            .profile-header { margin-bottom: 40px; }

            .header-inner { padding: 18px 0; }

            .header-nav { display: none; }

            .nav-toggle { display: flex; align-items: center; justify-content: center; }

            .profile-layout {
                grid-template-columns: 1fr;
                gap: 0;
                margin-bottom: 72px;
            }

            /* Sidebar becomes a horizontal pill-nav */
            .profile-sidebar {
                position: static;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 0;
                margin-bottom: 32px;
            }
            .profile-sidebar::-webkit-scrollbar { display: none; }

            .user-info-small { display: none; }

            .sidebar-menu {
                flex-direction: row;
                gap: 8px;
                padding-bottom: 16px;
                border-bottom: 1px solid var(--border-color);
            }

            .sidebar-menu li { flex-shrink: 0; }

            /* Hide logout in horizontal mode — it lives in the mobile drawer */
            .sidebar-menu li.sidebar-logout { display: none; }

            .sidebar-menu a,
            .sidebar-menu button.sidebar-btn {
                white-space: nowrap;
                padding: 9px 14px;
                font-size: 0.875rem;
                border: 1px solid var(--border-color);
                border-radius: 4px;
                width: auto;
            }

            .sidebar-menu a.active {
                background: var(--text-main);
                color: var(--surface-color);
                border-color: var(--text-main);
                box-shadow: none;
            }
        }

        /* ── Responsive: Mobile (≤ 480px) ─────────────────── */
        @media (max-width: 480px) {
            .container { padding: 0 16px; }

            h1 { font-size: 2rem; }

            .profile-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 24px 0 48px;
            }
        }
    </style>

    {{-- Additional page-specific styles --}}
    @stack('styles')
</head>
<body>

    <div class="container">
        {{-- Header --}}
        <header class="profile-header">

            <div class="header-inner">
               <a href="{{ url('/') }}" class="logo">
                <span class="aura-text">Aura</span><span class="dot">◼</span>
             </a>

                {{-- Desktop nav --}}
                <nav class="header-nav">
<a href="{{ route('shop.catalog') }}" 
   class="{{ request()->routeIs('shop.*') ? 'nav-active' : '' }}">
    
    <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000">
        <path d="M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10" stroke="#000000" stroke-width="1.5"></path>
        <path d="M14.8333 21V15C14.8333 13.8954 13.9379 13 12.8333 13H10.8333C9.72874 13 8.83331 13.8954 8.83331 15V21" stroke="#000000" stroke-width="1.5" stroke-miterlimit="16"></path>
        <path d="M21.8183 9.36418L20.1243 3.43517C20.0507 3.17759 19.8153 3 19.5474 3H15.5L15.9753 8.70377C15.9909 8.89043 16.0923 9.05904 16.2532 9.15495C16.6425 9.38698 17.4052 9.81699 18 10C19.0158 10.3125 20.5008 10.1998 21.3465 10.0958C21.6982 10.0526 21.9157 9.7049 21.8183 9.36418Z" stroke="#000000" stroke-width="1.5"></path>
        <path d="M14 10C14.5675 9.82538 15.2879 9.42589 15.6909 9.18807C15.8828 9.07486 15.9884 8.86103 15.9699 8.63904L15.5 3H8.5L8.03008 8.63904C8.01158 8.86103 8.11723 9.07486 8.30906 9.18807C8.71207 9.42589 9.4325 9.82538 10 10C11.493 10.4594 12.507 10.4594 14 10Z" stroke="#000000" stroke-width="1.5"></path>
        <path d="M3.87567 3.43517L2.18166 9.36418C2.08431 9.7049 2.3018 10.0526 2.6535 10.0958C3.49916 10.1998 4.98424 10.3125 6 10C6.59477 9.81699 7.35751 9.38698 7.74678 9.15495C7.90767 9.05904 8.00913 8.89043 8.02469 8.70377L8.5 3H4.45258C4.18469 3 3.94926 3.17759 3.87567 3.43517Z" stroke="#000000" stroke-width="1.5"></path>
    </svg>

    Shop
</a>

<a href="{{ route('cart.index') }}" 
   class="{{ request()->routeIs('cart.*') ? 'nav-active' : '' }}">
    
    <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000">
        <path d="M19.2609 9.69589L20.6455 18.6959C20.8319 19.9074 19.8945 21 18.6688 21H5.33122C4.10545 21 3.16809 19.9074 3.35448 18.6959L4.73909 9.69589C4.8892 8.72022 5.7287 8 6.71584 8H17.2842C18.2713 8 19.1108 8.72022 19.2609 9.69589Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>

    Cart
</a>                </nav>

                {{-- Hamburger (mobile only) --}}
                <button class="nav-toggle" id="navToggle" aria-label="Open menu" aria-expanded="false">
                    <i class="iconoir-menu" id="navToggleIcon"></i>
                </button>
            </div>

            {{-- Mobile drawer --}}
            <nav class="mobile-nav-drawer" id="mobileNavDrawer" aria-hidden="true">
                <a href="{{ route('shop.catalog') }}"><i class="iconoir-shop"></i> Shop</a>
                <a href="{{ route('cart.index') }}"><i class="iconoir-cart"></i> Cart</a>
                <a href="{{ route('profile.edit') }}"><i class="iconoir-user"></i> Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:10px;padding:12px 8px;background:none;border:none;color:black;cursor:pointer;font-family:inherit;font-size:0.95rem;border-radius:4px;width:100%;">
                        <i class="iconoir-log-out"></i> Log out
                    </button>
                </form>
            </nav>

             {{-- Alert Container --}}
            @if(session('alert'))
                <div class="container" style="margin-top: 20px;">
                    <x-alert :type="session('alert')['type']" 
                            :message="session('alert')['message']" 
                            :icon="session('alert')['icon'] ?? null" />
                </div>
            @endif
            
        </header>

        {{-- Main Layout with Sidebar and Content --}}
        <main class="profile-layout">
            {{-- Sidebar --}}
            <aside class="profile-sidebar">
                <div class="user-info-small">
                    <div class="avatar-small">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                        @else
                            <i class="iconoir-user"></i>
                        @endif
                    </div>
                    <div>
                        <h3>{{ auth()->user()->name }}</h3>
                        <p style="font-size: 0.875rem;">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    
                    @auth 
                        @if(in_array(auth()->user()->role , ['admin' , "employee"]))

                            <li><a href="{{ route('dashboard') }}"><i class="iconoir-app-window"></i> Dashboard</a></li>

                        @endif

                    @endauth
                    <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="iconoir-user"></i> Profile info</a></li>
                    

                    @auth 
                        @if(auth()->user()->role==="customer")

                                <li><a href="{{ route('profile.orders') }}" class="{{ request()->routeIs('profile.orders') ? 'active' : '' }}"><i class="iconoir-box-iso"></i> Orders</a></li>
                                <li><a href="{{ route('profile.addresses.index') }}" class="{{ request()->routeIs('profile.addresses.index') ? 'active' : '' }}"><i class="iconoir-map-pin"></i> Addresses</a></li>
                                <li><a href="{{ route('profile.wishlist.index') }}" class="{{ request()->routeIs('profile.wishlist.index') ? 'active' : '' }}"><i class="iconoir-heart"></i> Wishlist</a></li>
                        @endif

                    @endauth

    
                    {{-- <li><a href="#"><i class="iconoir-settings"></i> Settings</a></li> --}}
                    <li style="margin-top: 16px;" class="sidebar-logout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-btn">
                                <i class="iconoir-log-out"></i> Log out
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            {{-- Dynamic Content Area --}}
            <div class="profile-content">
                @yield('profile-content')
            </div>
        </main>

        {{-- Footer --}}
        <footer class="profile-footer">
            <div>© {{ date('Y') }} Aura Studio. All rights reserved.</div>
            <div class="footer-links">
                <a href="#">Help & Contact</a>
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <script>
        /* ── Mobile nav toggle ── */
        (function () {
            const toggle  = document.getElementById('navToggle');
            const drawer  = document.getElementById('mobileNavDrawer');
            const icon    = document.getElementById('navToggleIcon');
            if (!toggle) return;
            toggle.addEventListener('click', function () {
                const open = drawer.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open);
                drawer.setAttribute('aria-hidden', !open);
                icon.className = open ? 'iconoir-xmark' : 'iconoir-menu';
            });
        })();
    </script>
</body>
</html>
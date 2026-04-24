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
            --accent-clay: #D95835;        /* ← was #C4613A */
            --accent-sage: #4E8C5A;        /* ← was #7A9E7E */
            --accent-sand: #C4A06A;        /* ← was #D4C5A9 */
            --font-primary: 'DM Sans', sans-serif;
            --transition-speed: 150ms;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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

        .logo {
            font-size: 1.25rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-main);
            flex-shrink: 0;
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
            font-size: 0.9rem;
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
                <a href="{{ url('/') }}" class="logo">Aura.</a>

                {{-- Desktop nav --}}
                <nav class="header-nav">
                    <a href="{{ route('shop.catalog') }}" class="{{ request()->routeIs('shop.*') ? 'nav-active' : '' }}"><i class="iconoir-shop"></i> Shop</a>
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'nav-active' : '' }}"><i class="iconoir-cart"></i> Cart</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'nav-active' : '' }}"><i class="iconoir-user"></i> Account</a>
                </nav>

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
                    <!-- <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="iconoir-user"></i> Profile info</a></li> -->
                    

                    @auth 
                        @if(auth()->user()->role==="customer")

                                <li><a href="{{ route('profile.orders') }}"><i class="iconoir-box-iso"></i> Orders</a></li>
                                <li><a href="{{ route('profile.addresses.index') }}"><i class="iconoir-map-pin"></i> Addresses</a></li>
                                <li><a href="{{ route('profile.wishlist.index') }}"><i class="iconoir-heart"></i> Wishlist</a></li>
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
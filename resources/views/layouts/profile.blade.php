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
            --accent-clay: #C4613A;
            --accent-sage: #7A9E7E;
            --accent-sand: #D4C5A9;
            --font-primary: 'DM Sans', sans-serif;
            --transition-speed: 200ms;
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

        /* Header */
        .profile-header {
            padding: 40px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 64px;
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-main);
        }

        .header-nav {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .header-nav a {
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Profile Layout (Sidebar + Content) */
        .profile-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 64px;
            margin-bottom: 120px;
        }

        /* Sidebar */
        .profile-sidebar {
            position: sticky;
            top: 40px;
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
            border-radius: 50%;
            background: var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
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
            gap: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-secondary);
            border-radius: 6px;
            transition: var(--transition-speed);
        }

        .sidebar-menu a:hover {
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

        .sidebar-menu i {
            font-size: 1.25rem;
        }

        /* Main Content Area */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        /* Footer */
        .profile-footer {
            border-top: 1px solid var(--border-color);
            padding: 40px 0 80px;
            display: flex;
            justify-content: space-between;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--text-main);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .profile-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .profile-sidebar {
                position: static;
                display: flex;
                overflow-x: auto;
                padding-bottom: 16px;
            }
            .user-info-small {
                display: none;
            }
            .sidebar-menu {
                flex-direction: row;
            }
            .sidebar-menu a {
                white-space: nowrap;
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
            <a href="{{ url('/') }}" class="logo">Aura.</a>
            <nav class="header-nav">
                <a href="{{ route('shop.catalog') }}">Shop</a>
                <a href="#">Journal</a>
                <a href="{{ route('cart.index') }}"><i class="iconoir-cart"></i> Cart</a>
                <a href="{{ route('profile.edit') }}"><i class="iconoir-user"></i> Profile</a>
            </nav>
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
                    {{-- <li><a href="{{ route('profile.dashboard') }}"><i class="iconoir-app-window"></i> Dashboard</a></li> --}}
                    <li><a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="iconoir-user"></i> Profile info</a></li>
                    <li><a href="{{ route('profile.orders') }}"><i class="iconoir-box-iso"></i> Orders</a></li>
                    <li><a href="{{ route('profile.addresses.index') }}"><i class="iconoir-map-pin"></i> Addresses</a></li>
                    <li><a href="{{ route('profile.wishlist.index') }}"><i class="iconoir-heart"></i> Wishlist</a></li>
                    {{-- <li><a href="#"><i class="iconoir-settings"></i> Settings</a></li> --}}
                    <li style="margin-top: 24px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="background: none; border: none; display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-secondary); cursor: pointer; width: 100%;">
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
</body>
</html>
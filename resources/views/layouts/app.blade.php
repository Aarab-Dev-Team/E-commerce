<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aura Studio')</title>

    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css">

    <style>
        /* ==========================================================================
          variables 
           ========================================================================== */
        :root {
    --bg-color: #F5F4F0;
    --surface-color: #FFFFFF;
    --text-main: #1A1A18;
    --text-secondary: #6B6A66;
    --border-color: #E8E6E0;
    --accent-clay: #F04A20;       /* ← was #FB593B */
    --accent-sage: #4E8C5A;       /* ← was #7A9E7E */
    --accent-sand: #C4A06A;       /* ← was #D4C5A9 */
    --font-primary: 'DM Sans', sans-serif;
    --transition: all 150ms ease-out;
    --shadow-subtle: 0 2px 8px rgba(0,0,0,0.06);
    --container-width: 1248px;
    --gutter: 24px;

    /* alert */
    --alert-success-bg:     #C8E6CC;
    --alert-success-text:   #1E5E2A;
    --alert-success-border: #6BBF78;

    --alert-error-bg:       #FAD0C4;
    --alert-error-text:     #8B2500;
    --alert-error-border:   #E8714A;

    --alert-warning-bg:     #FDECC8;
    --alert-warning-text:   #7A4D00;
    --alert-warning-border: #F0B840;

    --alert-info-bg:        #C8DFEE;
    --alert-info-text:      #1A4A6B;
    --alert-info-border:    #5FA8D8;
}


        .alert-success {
            --alert-bg: var(--alert-success-bg);
            --alert-text: var(--alert-success-text);
            --alert-border: var(--alert-success-border);
        }
        .alert-error {
            --alert-bg: var(--alert-error-bg);
            --alert-text: var(--alert-error-text);
            --alert-border: var(--alert-error-border);
        }
        .alert-warning {
            --alert-bg: var(--alert-warning-bg);
            --alert-text: var(--alert-warning-text);
            --alert-border: var(--alert-warning-border);
        }
        .alert-info {
            --alert-bg: var(--alert-info-bg);
            --alert-text: var(--alert-info-text);
            --alert-border: var(--alert-info-border);
        }


        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-primary);
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }

        a { color: inherit; text-decoration: none; transition: var(--transition); }
        button, input, select { font-family: inherit; outline: none; }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 300;
            letter-spacing: -0.02em;
            color: var(--text-main);
        }

        h1 { font-size: 64px; line-height: 1.1; }
        h2 { font-size: 40px; line-height: 1.2; }
        h3 { font-size: 24px; line-height: 1.3; font-weight: 400; }

        p, span, li {
            font-size: 16px;
            line-height: 1.7;
            font-weight: 300;
            color: var(--text-secondary);
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 30px var(--gutter);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }
        }

        /* ==========================================================================
          header and topbar
           ========================================================================== */

        .top-bar-container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0px var(--gutter);  
        }

        .top-bar {
            background-color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            padding: 8px 0;
            font-size: 12px;
        }
        .top-bar .top-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar p {
            font-size: 12px;
            color: var(--surface-color);
        }

        .main-header {
            background-color: rgba(245, 244, 240, 0.98);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(8px);
        }

        .header-container {
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .main-header .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px var(--gutter);
        }

        @media (max-width: 1024px) {
            .main-header .header-container {
                padding: 16px var(--gutter);
            }
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
        .search-bar {
            flex: 1;
            max-width: 400px;
            position: relative;
            margin: 0 40px;
        }
        .search-bar input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: var(--font-family);
            font-weight: 300;
            font-size: 14px;
            color: var(--text-main);
        }
        .search-bar input:focus {
            outline: none;
            border-color: var(--text-secondary);
        }
        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 18px;
        }
        .nav-links {
            display: flex;
            gap: 32px;
        }
        .nav-links a {
            color: var(--text-main);
            font-weight: 400;
            font-size: 14px;
        }
        .nav-links a:hover {
            color: var(--text-secondary);
            text-decoration: underline;
            text-underline-offset: 4px;
        }
        .nav-links a.active {
            font-weight: 500;
            text-decoration: underline;
            text-underline-offset: 4px;
        }
        .header-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .header-actions i {
            font-size: 22px;
            color: var(--text-main);
            cursor: pointer;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-main);
            order: -1;
            z-index: 301;
            position: relative;
        }

        /* ==========================================================================
          catalog components
           ========================================================================== */
        .page-header {
            padding: 100px 0 80px;
            position: relative;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            display: flex;
            gap: 8px;
        }

        .page-header p {
            max-width: 500px;
            font-size: 18px;
            color: var(--text-secondary);
        }

        .decor-svg {
            position: absolute;
            right: 48px;
            top: 50%;
            transform: translateY(-50%);
            width: 280px;
            height: 280px;
            pointer-events: none;
        }

        .organic-path {
            fill: none;
            stroke: var(--text-secondary);
            stroke-width: 1.5px;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0.4;
        }

        .shop-container {
            display: grid;
            grid-template-columns: 2fr 10fr;
            gap: 48px;
            padding-bottom: 120px;
        }

        /*filters + Sidebar Container */

           
.sidebar { 
    padding-right: 40px; 
}

/* Active Filters Section */
.active-filters {
    margin-bottom: 48px;
}

.filter-label-sm {
    display: block;
    font-size: 12px;
    font-weight: 500;
    text-transform: lowercase; /* Editorial style choice */
    color: var(--text-muted);
    margin-bottom: 12px;
    letter-spacing: 0.05em;
}

.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.filter-pill {
    background-color: var(--accent-clay); /* Warm Sand Accent */
    color: var(--bg-color);
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 500;
}

.filter-clear {
    font-size: 13px;
    color: var(--text-muted);
    text-decoration: underline;
    text-underline-offset: 4px;
    margin-left: 8px;
    transition: color 200ms ease-out;
}

.filter-clear:hover { color: var(--text-main); }

/* Filter Groups */
.filter-group { 
    margin-bottom: 40px; 
    border-top: 1px solid var(--border-color);
    padding-top: 24px;
}

.filter-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    margin-bottom: 20px;
}

.filter-group h3 {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-count {
    font-weight: 300;
    color: var(--text-muted);
    font-size: 12px;
}

.accordion-icon {
    font-size: 16px;
    color: var(--text-muted);
    transition: transform 200ms ease-out;
}

.filter-group.collapsed .filter-group-content { display: none; }
.filter-group.collapsed .accordion-icon { transform: rotate(-90deg); }

/* Filter Items (Checkboxes) */
.filter-list { list-style: none; }

.filter-item {
    display: flex;
    align-items: center;
    margin-bottom: 14px;
    cursor: pointer;
    font-size: 14px;
    color: var(--text-muted);
    transition: color 200ms ease-out;
}

.filter-item:hover { color: var(--text-main); }

.filter-checkbox {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    margin-right: 14px;
    background: var(--surface-bg);
    cursor: pointer;
    position: relative;
    transition: all 200ms ease-out;
}

.filter-checkbox:checked {
    background: var(--text-main);
    border-color: var(--text-main);
}

.filter-checkbox:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 1.5px 1.5px 0;
    transform: rotate(45deg);
}

/* Price Range Specifics */
.price-range-wrap {
    padding-top: 8px;
}

.price-range-display {
    font-size: 14px;
    color: var(--text-main);
    margin-bottom: 16px;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.price-input-group label {
    font-size: 11px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 4px;
}

.price-input {
    width: 100%;
    border: 1px solid var(--border-color);
    background: var(--surface-bg);
    padding: 8px;
    font-family: var(--font-main);
    font-size: 13px;
    border-radius: 4px;
    outline: none;
}

.price-input:focus { border-color: var(--text-main); }

.price-apply-btn {
    width: 100%;
    padding: 10px;
    background: transparent;
    border: 1px solid var(--text-main);
    font-family: var(--font-main);
    font-size: 13px;
    cursor: pointer;
    transition: all 200ms ease-out;
}

.price-apply-btn:hover {
    background: var(--text-main);
    color: var(--bg-color);
}
      


        /* products section*/
        .products-area { }
        .sorting-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }
        .sort-dropdown {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sort-dropdown select {
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: white;
            font-family: var(--font-main);
            color: var(--text-main);
            outline: none;
            cursor: pointer;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        /* product card*/
        .product-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-subtle);
        }
        .product-image-container {
            height: 320px;
            background: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }
        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit :contain;
        }
        .placeholder-icon {
            font-size: 32px;
            color: var(--border-color);
            stroke-width: 1px;
        }

        /* Quick Add Form */
        .quick-add-form {
            position: absolute;
            bottom: 16px;
            right: 16px;
            z-index: 5;
        }

        .quick-add-btn {
            width: 40px;
            height: 40px;
            background: var(--text-main);
            color: var(--surface-color);
            border: none;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(10px);
            transition: var(--transition-speed);
            cursor: pointer;
        }
        .product-card:hover .quick-add-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .quick-add-btn:hover {
            background: var(--text-secondary);
        }
        .product-info { padding: 20px; }
        .product-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            color: var(--text-main);
        }
        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* pagination*/
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 64px;
        }
        .page-link {
             width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid var(--border-color);
      background: var(--surface-bg);
      border-radius: 4px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.875rem;
      transition: var(--transition-speed);
        }
        .page-link.active {
            background: var(--text-main); color: var(--bg-color); border-color: var(--text-main); 
            font-weight: 500;
        }
        .page-link:not(.disabled):hover {
            background: var(--border-color);
            color: var(--text-main);
        }
        .page-link.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* ==========================================================================
          footer 
           ========================================================================== */
        .footer {
             background-color: black;
            border-top: 1px solid var(--border-color);
            padding: 80px 0 40px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 4fr 2fr 2fr 2fr;
            gap: 48px;
            margin-bottom: 80px;
        }
        .footer-col h4 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            color : var(--accent-clay) ; 
        }
        .footer-col p { font-size: 13px; margin-bottom: 24px; }
        .newsletter-form {
            display: flex;
            gap: 8px;
            max-width: 320px;
        }
        @media (max-width: 768px) {
            .newsletter-form {
                max-width: 100%;
            }
        }
        .newsletter-form input {
            flex: 1;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            font-size: 13px;
            border-radius: 4px;
        }
        .btn-filled {
            background: var(--accent-clay);
            color: var(--surface-color);
            border: none;
            padding: 0 24px;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
        }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { font-size: 13px; color: var(--text-secondary); }
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }
        .social-links { display: flex; gap: 20px; }
        .social-links a { color: white; font-size: 18px; }

        .copyright{
            color : white ; 
        }

        /* ==========================================================================
          optimization
           ========================================================================== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 28px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            transition: var(--transition);
            border: 1px solid transparent;
        }
        .btn-primary {
            background: var(--text-main);
            color: var(--surface-color);
        }
        .btn-ghost {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--text-main);
        }

    


      /* ==========================================================================
          wishlist style    
           ========================================================================== */
/* Wishlist Button */
.wishlist-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 36px;
    height: 36px;
    background: var(--surface-color);
    color: var(--text-main);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition));
    cursor: pointer;
    z-index: 5;
}

.wishlist-btn i {
    font-size: 18px;
    transition: var(--transition);
}

.wishlist-btn:hover {
    color: var(--accent-clay);
    border-color: var(--accent-clay);
}

.wishlist-btn.active {
    background: var(--accent-clay);
    color: var(--surface-color);
    border-color: var(--accent-clay);
}

.wishlist-btn.active i {
    color: var(--surface-color);
}



        /* ==========================================================================
          responsive 
           ========================================================================== */
        @media (max-width: 1024px) {
            .nav-links { gap: 20px; }
            .search-bar { margin: 0 20px; }
        }

        @media (max-width: 992px) {
            .shop-container { grid-template-columns: 1fr; }
            .products-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: repeat(2, 2fr); }
            .decor-svg { display: none; }
        }

        @media (max-width: 768px) {
            h1 { font-size: 40px; }
            
            .top-bar .top-bar-container {
                flex-direction: column;
                text-align: center;
                gap: 4px;
            }

            .menu-toggle { display: block; }
            
            .nav-links {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: auto;
                background: var(--surface-color);
                flex-direction: column;
                padding: 120px 40px 60px;
                transform: translateY(-100%);
                transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease, visibility 0.3s;
                z-index: 300;
                box-shadow: none;
                border-bottom: 1px solid var(--border-color);
                visibility: hidden;
                opacity: 0;
            }

            .nav-links.active {
                transform: translateY(0);
                visibility: visible;
                opacity: 1;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }

            .nav-links a {
                font-size: 20px;
            }

            .search-bar {
                display: none; /* Can be moved inside nav-links or shown on toggle */
            }

            .header-actions { gap: 15px; }

            .footer-grid { grid-template-columns: 1fr; gap: 32px; }
            
            .footer-bottom {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .products-grid { grid-template-columns: 1fr; }
            .header-actions a:not(:last-child) { display: none; } /* Hide some actions on very small screens if needed */
            .header-actions i { font-size: 20px; }
        }


    </style>
    @stack('styles')
</head>
<body>

    <div class="top-bar">
        <div class="top-bar-container">
            <div style="display: flex; gap: 16px;">
                <p>EN / USD</p>
                <p>Need help? +1 800 123 4567</p>
            </div>
            <p>Complimentary shipping on orders over $300</p>
        </div>
    </div>

    <header class="main-header" >
        <div class="header-container">
            <button class="menu-toggle" id="menuToggle">
                <i class="iconoir-menu"></i>
            </button>

            <a href="{{ url('/') }}" class="logo">
    <span class="aura-text">Aura</span><span class="dot">◼</span>
</a>
            
            <nav class="nav-links">
                <a href="{{ route('shop.catalog') }}" class="{{ request()->routeIs('shop.catalog') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('about') }}">About</a>
            </nav>

            <div class="search-bar">
                <i class="iconoir-search"></i>
                <input type="text" placeholder="Search catalog...">
            </div>

            <div class="header-actions">
                @auth
                    <a href="{{ route('profile.edit') }}"><i class="iconoir-user"></i></a>
                    <a href="{{ route('cart.index') }}"><i class="iconoir-shopping-bag"></i></a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; cursor:pointer; padding:0;">
                            <i class="iconoir-log-out"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"><i class="iconoir-user"></i></a>
                    <a href="{{ route('cart.index') }}"><i class="iconoir-shopping-bag"></i></a>
                @endauth
            </div>
        </div>


    {{-- Alert Container --}}
    @if(session('alert'))
        <div  ">
            <x-alert :type="session('alert')['type']" 
                     :message="session('alert')['message']" 
                     :icon="session('alert')['icon'] ?? null" />
        </div>
    @endif

</header>



    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Aura Journal</h4>
                    <p>Subscribe to our irregular dispatches on design, architecture, and slow living.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="Email address">
                        <button type="submit" class="btn-filled">Join</button>
                    </form>
                </div>
                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul class="footer-links">
                        <li><a href="#">New arrivals</a></li>
                        <li><a href="#">Objects</a></li>
                        <li><a href="#">Textiles</a></li>
                        <li><a href="#">Furniture</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Assistance</h4>
                    <ul class="footer-links">
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Shipping & returns</a></li>
                        <li><a href="#">Care guide</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Studio</h4>
                    <ul class="footer-links">
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Journal</a></li>
                        <li><a href="#">Stockists</a></li>
                        <li><a href="#">Terms & conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">&copy; {{ date('Y') }} Aura Studio. All rights reserved.</div>
                <div class="social-links">
                    <a href="#"><i class="iconoir-instagram"></i></a>
                    <a href="#"><i class="iconoir-pinterest"></i></a>
                    <a href="#"><i class="iconoir-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
<script>
(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.className = 'iconoir-xmark';
                body.style.overflow = 'hidden'; // Prevent scroll
            } else {
                icon.className = 'iconoir-menu';
                body.style.overflow = '';
            }
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (navLinks && navLinks.classList.contains('active')) {
            if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                navLinks.classList.remove('active');
                menuToggle.querySelector('i').className = 'iconoir-menu';
                body.style.overflow = '';
            }
        }
    });

    // ── Quick-add AJAX (intercepts every .quick-add-form on any page) ──
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('.quick-add-form');
        if (!form) return;           // not our form
        e.preventDefault();

        const btn  = form.querySelector('.quick-add-btn');
        const icon = btn?.querySelector('i');
        if (btn) btn.disabled = true;

        try {
            const res  = await fetch(form.action, {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept'      : 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify({ quantity: 1 }),
            });
            const data = await res.json();

            if (data.success) {
                // ✓ visual feedback on the button
                if (icon) icon.className = 'iconoir-check';
                if (btn)  btn.style.background = 'var(--accent-sage)';

                // update nav cart badge(s)
                document.querySelectorAll('[data-cart-count]').forEach(el => {
                    el.textContent = data.cart_count;
                    el.dataset.cartCount = data.cart_count;
                });

                setTimeout(() => {
                    if (icon) icon.className = 'iconoir-plus';
                    if (btn)  { btn.style.background = ''; btn.disabled = false; }
                }, 1500);
            } else {
                if (btn) btn.disabled = false;
            }
        } catch {
            if (btn) btn.disabled = false;
        }
    });
})();
</script>
</body>
</html>
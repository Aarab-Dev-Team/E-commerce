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
            --accent-clay: #C4613A;
            --accent-sage: #7A9E7E;
            --accent-sand: #D4C5A9;
            --font-primary: 'DM Sans', sans-serif;
            --transition: all 150ms ease-out;
            --shadow-subtle: 0 2px 8px rgba(0,0,0,0.06);
            --container-width: 1248px;
            --gutter: 24px;
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
            padding: 24px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0px var(--gutter);  
        }

        .main-header .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 24px;
            font-weight: 500;
            color: var(--text-main);
            letter-spacing: -0.04em;
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
        }
        .header-actions i {
            font-size: 22px;
            color: var(--text-main);
            cursor: pointer;
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
            width: 220px;
            height: 220px;
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

        /*filters */
        .sidebar { padding-top: 8px; }
        .filter-group { margin-bottom: 40px; }
        .filter-group h3 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .filter-list { list-style: none; }
        .filter-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 14px;
            color: var(--text-secondary);
        }
        .filter-item:hover { color: var(--text-main); }
        .filter-checkbox {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            margin-right: 12px;
            background: var(--surface-color);
            transition: var(--transition);
        }
        .filter-checkbox:checked {
            background: var(--text-main);
            border-color: var(--text-main);
        }
        .filter-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid var(--surface-color);
            border-width: 0 1px 1px 0;
            transform: rotate(45deg);
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
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 14px;
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
            border-radius: 8px;
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
            object-fit: cover;
        }
        .placeholder-icon {
            font-size: 32px;
            color: var(--border-color);
            stroke-width: 1px;
        }
        .quick-add-btn {
            position: absolute;
            bottom: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: var(--text-main);
            color: var(--surface-color);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(10px);
            transition: var(--transition);
            cursor: pointer;
        }
        .product-card:hover .quick-add-btn {
            opacity: 1;
            transform: translateY(0);
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
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            font-size: 14px;
            color: var(--text-secondary);
            border-radius: 4px;
        }
        .page-link.active {
            color: var(--text-main);
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
             background-color: var(--surface-color);
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
        }
        .footer-col p { font-size: 13px; margin-bottom: 24px; }
        .newsletter-form {
            display: flex;
            gap: 8px;
            max-width: 320px;
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
            background: var(--text-main);
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
        .social-links a { color: var(--text-secondary); font-size: 18px; }

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

        /* Accordion Filter Groups */
.filter-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.filter-group-header h3 {
    margin-bottom: 0;
}

.accordion-icon {
    font-size: 16px;
    transition: transform 0.2s ease;
}

.filter-group.collapsed .accordion-icon {
    transform: rotate(-90deg);
}

.filter-group.collapsed .filter-group-content {
    display: none;
}

.filter-group-content {
    margin-top: 16px;
}


        /* ==========================================================================
          responsive 
           ========================================================================== */
        @media (max-width: 992px) {
            .shop-container { grid-template-columns: 1fr; }
            .products-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .decor-svg { display: none; }
        }
        @media (max-width: 768px) {
            h1 { font-size: 40px; }
            .nav-menu { display: none; }
            .search-box { display: none; }
            .products-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .top-bar { flex-direction: column; gap: 8px; }
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

    <header class="main-header">
    <div class="header-container">
        <a href="{{ url('/') }}" class="logo">Aura.</a>
        
        <nav class="nav-links">
            <a href="{{ route('shop.catalog') }}" class="{{ request()->routeIs('shop.catalog') ? 'active' : '' }}">Shop</a>
            <a href="#">Editorial</a>
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
    function quickAdd(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(async response => {
        const text = await response.text();
        console.log('Response status:', response.status);
        console.log('Response text:', text);
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Invalid JSON response');
            return { success: false };
        }
    })
    .then(data => {
        console.log('Parsed data:', data);
        if (data.success) {
            alert('Product added to cart');
        } else {
            alert('Could not add product');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred');
    });
}

</script>
</body>
</html>
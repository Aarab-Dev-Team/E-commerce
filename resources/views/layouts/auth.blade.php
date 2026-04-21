<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Account — Aura Studio')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css">
    
       <style>
        :root {
            --bg-color: #EBE9E1;
            --surface-color: #FFFFFF;
            --text-main: #111111;
            --text-secondary: #4A4A45;
            --border-color: #D1CFC7;
            --accent-sage: #388042;
            --font-family: 'Inter', sans-serif;
            --transition: 200ms ease-out;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Typography */
        h1 { font-size: 40px; font-weight: 400; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 8px; }
        p { font-size: 16px; font-weight: 300; line-height: 1.6; color: var(--text-secondary); }
        label { font-size: 14px; font-weight: 500; color: var(--text-main); margin-bottom: 8px; display: block; }
        
        /* Layout */
        .auth-header {
            padding: 40px 0;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--surface-color);
        }

        .logo {
            font-size: 24px;
            font-weight: 500;
            color: var(--text-main);
            letter-spacing: -0.04em;
            text-decoration: none;
        }

        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 24px;
        }

        .auth-card {
            background: var(--surface-color);
            width: 100%;
            max-width: 440px;
            padding: 48px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        /* Form Elements */
        .form-group { margin-bottom: 24px; position: relative; }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: var(--font-family);
            font-size: 15px;
            font-weight: 300;
            color: var(--text-main);
            transition: var(--transition);
        }

        input:focus {
            outline: none;
            border-color: var(--text-secondary);
            background: var(--surface-color);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 42px;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 18px;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--text-main);
            color: var(--surface-color);
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-ghost {
            width: 100%;
            padding: 14px;
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 16px;
            transition: var(--transition);
        }

        .btn-ghost:hover {
            background-color: var(--bg-color);
        }

        /* Utilities */
        .flex-between { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .text-link { font-size: 13px; color: var(--text-secondary); text-decoration: underline; text-underline-offset: 3px; }
        .text-link:hover { color: var(--text-main); }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 32px 0;
            color: var(--border-color);
            font-size: 12px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        .divider span { padding: 0 10px; color: var(--text-secondary); }

        .auth-footer {
            padding: 40px;
            text-align: center;
            border-top: 1px solid var(--border-color);
            font-size: 12px;
        }

        /* Organic Illustration Placeholder */
        .sketch-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .auth-state { display: none; }
        .auth-state.active { display: block; }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .checkbox-container input { display: none; }
        .custom-check {
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-color);
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .checkbox-container input:checked + .custom-check {
            background-color: var(--text-main);
            border-color: var(--text-main);
        }

        .checkbox-container input:checked + .custom-check::after {
            content: '✓';
            color: white;
            font-size: 10px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <header class="auth-header">
        <a href="{{ url('/') }}" class="logo">Aura.</a>
    </header>

    <div class="auth-container">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>

    <footer class="auth-footer">
        <div style="display: flex; justify-content: center; gap: 24px; margin-bottom: 16px;">
            <a href="#" class="text-link" style="font-size: 12px;">Privacy Policy</a>
            <a href="#" class="text-link" style="font-size: 12px;">Terms of Use</a>
            <a href="#" class="text-link" style="font-size: 12px;">Contact Support</a>
        </div>
        <p style="font-size: 11px; opacity: 0.7;">© 2026 Aura Studio. Secure encrypted connection.</p>
    </footer>

    @stack('scripts')
</body>
</html>
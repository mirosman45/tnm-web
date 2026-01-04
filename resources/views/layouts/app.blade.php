<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --surface: #ffffff;
            --background: #f8fafc;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --transition: .3s ease;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .06);
            --shadow-md: 0 6px 16px rgba(0, 0, 0, .12);
            --shadow-xl: 0 18px 40px rgba(0, 0, 0, .18);
        }

        [data-theme="dark"] {
            --surface: #1f2937;
            --background: #111827;
            --text: #e5e7eb;
            --text-muted: #94a3b8;
            --border: #374151;
            --primary: #818cf8;
            --primary-dark: #6366f1;
            --primary-light: rgba(99, 102, 241, .18);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            margin: 0;
        }

        /* ===== NAVBAR ===== */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        nav .nav-left a,
        nav .nav-right a,
        nav .nav-right button {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            background: var(--primary);
            font-weight: 500;
            transition: background var(--transition);
        }

        nav .nav-left a:hover,
        nav .nav-right a:hover,
        nav .nav-right button:hover {
            background: var(--primary-dark);
        }

        nav .nav-left a {
            margin-right: 0.75rem;
        }

        nav .nav-right {
            display: flex;
            gap: 0.5rem;
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            cursor: pointer;
            border: none;
            border-radius: 50%;
            background: var(--primary-light);
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            transition: transform var(--transition), background var(--transition);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            background: var(--primary-dark);
            color: #fff;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* ===== NEWS CARD / GENERIC CARDS ===== */
        .card {
            background: var(--surface);
            padding: 1.5rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            transition: transform var(--transition), box-shadow var(--transition);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            border: none;
            background: var(--primary);
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: background var(--transition);
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--surface);
            text-align: center;
            padding: 2rem 1rem;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            margin-top: 2rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width:768px) {
            nav {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body data-theme="light">

    <!-- NAVIGATION -->
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('news.breaking') }}">Breaking News</a>
            <a href="{{ route('news.day') }}">Day News</a>
            <a href="{{ route('news.week') }}">Week News</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div class="nav-right">
            <button class="theme-toggle" id="themeToggle">🌙</button>
            @guest
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('register') }}">Sign up</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout ({{ Auth::user()->name }})</button>
                </form>
            @endguest
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>

    <script>
        // THEME TOGGLE
        const toggleBtn = document.getElementById('themeToggle');
        toggleBtn.addEventListener('click', () => {
            const root = document.body;
            const isDark = root.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            root.setAttribute('data-theme', newTheme);
            toggleBtn.textContent = newTheme === 'dark' ? '☀️' : '🌙';
            localStorage.setItem('theme', newTheme);
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.body.setAttribute('data-theme', savedTheme);
            toggleBtn.textContent = savedTheme === 'dark' ? '☀️' : '🌙';
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>@yield('title') - TNM News</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --background: #f5f7fb;
            --surface: #ffffff;
            --text: #1f2937;
            --text-muted: #6b7280;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.25);
            --danger: #ef4444;
            --border: #e5e7eb;
            --radius: 12px;
            --transition: 0.3s ease;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* SYSTEM DARK MODE */
        [data-theme="dark"] {
            --background: #0f172a;
            --surface: #020617;
            --text: #e5e7eb;
            --text-muted: #9ca3af;
            --border: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            color: var(--text);
            transition: background var(--transition), color var(--transition);
        }

        nav:first-of-type {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            gap: 30px;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-md);
            flex-wrap: wrap;
            justify-content: center;
        }

        nav:first-of-type a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        nav:first-of-type a:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        #live-datetime {
            background: rgba(0, 0, 0, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            color: #fff;
            font-family: monospace;
            transition: var(--transition);
        }

        #live-datetime:hover {
            background: rgba(0, 0, 0, 0.35);
        }

        .theme-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #fff;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 30%;
            cursor: default;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: rotate(10deg) scale(1.05);
        }

        nav:nth-of-type(2) {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 12px 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-sm);
            flex-wrap: wrap;
        }

        nav:nth-of-type(2) ul {
            display: flex;
            gap: 15px;
            list-style: none;
        }

        nav:nth-of-type(2) li a,
        nav:nth-of-type(2) li button {
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        nav:nth-of-type(2) li a {
            background: var(--primary);
            color: #fff;
            text-decoration: none;
        }

        nav:nth-of-type(2) li a:hover {
            background: var(--primary-dark);
            transform: translateY(-2px) scale(1.03);
        }

        nav:nth-of-type(2) li button {
            background: transparent;
            color: var(--danger);
            border: 2px solid var(--danger);
        }

        nav:nth-of-type(2) li button:hover {
            background: var(--danger);
            color: #fff;
            transform: translateY(-2px);
        }

        .social-lang-bar {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        .social-icons {
            display: flex;
            gap: 14px;
        }

        .social-icons a {
            font-size: 1.4rem;
            color: var(--text);
            transition: var(--transition);
        }

        .social-icons a:hover {
            color: var(--primary);
            transform: translateY(-3px) scale(1.15);
        }

        select {
            padding: 0.55rem 1rem;
            border-radius: var(--radius);
            border: 2px solid var(--border);
            font-weight: 600;
            cursor: pointer;
            background: var(--surface);
            color: var(--text);
            transition: var(--transition);
        }

        select:hover {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        footer {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            text-align: center;
            padding: 30px;
            margin-top: 60px;
            transition: var(--transition);
        }

        footer:hover {
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body>

    <nav>
        <a href="{{ route('home') }}">📰 {{ __('messages.home') }}</a>
        <a href="{{ route('news.breaking') }}">🔴 {{ __('messages.breaking_news') }}</a>
        <a href="{{ route('news.day') }}">📅 {{ __('messages.news_of_day') }}</a>
        <a href="{{ route('news.week') }}">📆 {{ __('messages.news_of_week') }}</a>
        <a href="{{ route('books.index') }}">📚 Books</a>
        <a href="{{ route('about') }}">ℹ️ {{ __('messages.about') }}</a>
        <a href="{{ route('contact') }}">📧 {{ __('messages.contact') }}</a>
        <span id="live-datetime"></span>
    </nav>

    <nav>
        <ul>
            @guest
                <li><a href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                <li><a href="{{ route('register') }}">{{ __('messages.sign_up') }}</a></li>
            @else
                <li>
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('messages.logout') }} ({{ Auth::user()->name }})
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>

        <div class="social-lang-bar">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-telegram"></i></a>
            </div>

            <button class="theme-toggle" id="themeToggle">🌙</button>

            <select onchange="location=this.value">
                <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                    English</option>
                <option value="{{ route('lang.switch', 'ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}>
                    پښتو</option>
                <option value="{{ route('lang.switch', 'fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}>
                    دری</option>
            </select>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>{{ __('messages.rights_reserved') }}</p>
    </footer>

    <script>
        function updateDateTime() {
            const n = new Date();
            document.getElementById('live-datetime').textContent =
                `${n.toLocaleTimeString()} | ${n.toLocaleDateString()}`;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        /* SYSTEM DARK MODE ONLY */
        const root = document.documentElement;
        const toggle = document.getElementById('themeToggle');
        const media = window.matchMedia('(prefers-color-scheme: dark)');

        function applyTheme() {
            const dark = media.matches;
            root.setAttribute('data-theme', dark ? 'dark' : 'light');
            toggle.textContent = dark ? '☀️' : '🌙';
        }

        applyTheme();
        media.addEventListener('change', applyTheme);
    </script>

</body>

</html>
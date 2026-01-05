<!DOCTYPE html>
<html>

<head>
    <title>@yield('title') - TNM News</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* RESET & BASE STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        /* NAVBAR - PRIMARY */
        nav:first-of-type {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-md);
            flex-wrap: wrap;
        }

        nav:first-of-type a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all var(--transition);
            position: relative;
        }

        nav:first-of-type a:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }

        nav:first-of-type a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fff;
            transition: width var(--transition);
        }

        nav:first-of-type a:hover::after {
            width: 100%;
        }

        /* DATETIME BADGE */
        #live-datetime {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            font-family: 'Courier New', monospace;
        }

        /* THEME TOGGLE */
        .theme-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #fff;
            color: #fff;
            border-radius: 50%;
            width:  35px;
            height: 35px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(20deg) scale(1.1);
        }

        /* NAVBAR - SECONDARY (AUTH & LANGUAGE) */
        nav:nth-of-type(2) {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 12px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--shadow-sm);
        }

        nav:nth-of-type(2) ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        nav:nth-of-type(2) li a,
        nav:nth-of-type(2) li button {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        }

        nav:nth-of-type(2) li:first-child a {
            background: #4f46e5;
            color: #fff;
        }

        nav:nth-of-type(2) li:nth-child(2) a {
            background: #9793d7;
            color: #fff;
        }

        nav:nth-of-type(2) li a:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
        }

        nav:nth-of-type(2) li:first-child a:hover {
            background: #645cbd;
        }

        nav:nth-of-type(2) li:nth-child(2) a:hover {
            background: #817bc0;
        }

        nav:nth-of-type(2) li a:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        nav:nth-of-type(2) li button {
            background: transparent;
            color: var(--danger);
            border: 2px solid var(--danger);
        }

        nav:nth-of-type(2) li button:hover {
            background: var(--danger);
            color: #fff;
        }

        /* LANGUAGE SELECTOR */
        select {
            padding: 0.6rem 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            font-weight: 500;
            transition: all var(--transition);
            margin-left: auto;
        }

        select:hover {
            border-color: var(--primary);
        }

        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* PAGE CONTENT */
        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* HEADINGS */
        h1,
        h2 {
            margin-bottom: 25px;
            color: var(--text);
            font-weight: 800;
        }

        h1 {
            font-size: 2.5rem;
        }

        h2 {
            font-size: 2rem;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 15px;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 15px;
            line-height: 1.8;
        }

        /* FOOTER */
        footer {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            text-align: center;
            padding: 30px;
            margin-top: 60px;
            box-shadow: var(--shadow-md);
        }

        footer p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        /* RESPONSIVE ADJUSTMENTS */
        @media (max-width: 768px) {
            nav:first-of-type {
                gap: 15px;
                padding: 12px 10px;
            }

            nav:first-of-type a {
                font-size: 0.9rem;
            }

            #live-datetime {
                display: none;
            }

            nav:nth-of-type(2) {
                flex-wrap: wrap;
                padding: 10px;
            }

            select {
                margin-left: 0;
                margin-top: 10px;
            }

            .content {
                margin: 20px auto;
                padding: 0 15px;
            }

            h1 {
                font-size: 1.8rem;
            }

            h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR PRIMARY -->
    <nav>
        <a href="{{ route('home') }}">📰 {{ __('messages.home') }}</a>
        <a href="{{ route('news.breaking') }}">🔴 {{ __('messages.breaking_news') }}</a>
        <a href="{{ route('news.day') }}">📅 {{ __('messages.news_of_day') }}</a>
        <a href="{{ route('news.week') }}">📆 {{ __('messages.news_of_week') }}</a>
        <a href="{{ route('books.index') }}">📚 Books</a>
        <a href="{{ route('about') }}">ℹ️ {{ __('messages.about') }}</a>
        <a href="{{ route('contact') }}">📧 {{ __('messages.contact') }}</a>
        <span id="live-datetime"></span>
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">🌙</button>
    </nav>

    <!-- NAVBAR SECONDARY - AUTH & LANGUAGE -->
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
        
        <select onchange="location=this.value">
            <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}> English</option>
            <option value="{{ route('lang.switch', 'ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}> پښتو</option>
            <option value="{{ route('lang.switch', 'fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}> دری</option>
        </select>
        
    </nav>

    <!-- MAIN CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>{{ __('messages.rights_reserved') }}</p>
    </footer>

    <script>
        // Live Date/Time
        function updateDateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();

            document.getElementById('live-datetime').textContent = `${hours}:${minutes}:${seconds} | ${day}/${month}/${year}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Theme Toggle
        const root = document.documentElement;
        const toggleBtn = document.getElementById('themeToggle');

        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const activeTheme = savedTheme ?? (systemDark ? 'dark' : 'light');

        root.setAttribute('data-theme', activeTheme);
        toggleBtn.textContent = activeTheme === 'dark' ? '☀️' : '🌙';

        toggleBtn.addEventListener('click', () => {
            const isDark = root.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            root.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            toggleBtn.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                const theme = e.matches ? 'dark' : 'light';
                root.setAttribute('data-theme', theme);
                toggleBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
            }
        });
    </script>



</body>

</html>

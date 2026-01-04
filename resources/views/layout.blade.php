<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <style>
        /* NAVBAR */
        nav {
            background-color: #0056b3;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }






        /* PAGE CONTENT (OUTSIDE NAVBAR) */
        .content {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
            text-align: left;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
            color: #111827;
        }

        /* Navbar */
        nav {
            background: #1f2937;
            color: #fff;
            padding: 15px 30px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        nav a:hover {
            color: #3b82f6;
        }

        /* Main content */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1,
        h2 {
            margin-bottom: 15px;
            color: #111827;
        }

        p {
            color: #4b5563;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        /* News Sections */
        .news-section {
            margin-bottom: 40px;
        }

        .news-section h2 {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 5px;
            margin-bottom: 20px;
            color: #1e40af;
        }

        .news-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .news-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .news-card h3 {
            margin-bottom: 10px;
            color: #111827;
        }

        /* Responsive grid for Day & Week news */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Footer */
        footer {
            background: #1f2937;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: 50px;
        }

        nav {
            background: #1f2937;
            color: #fff;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        nav a:hover {
            color: #3b82f6;
        }

        /* Live date-time badge */
        .datetime-badge {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #fff;
            padding: 4px 10px;
            border-radius: 12px;
            font-family: monospace;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .datetime-badge:hover {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }


        nav ul li a {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            margin-left: 0.5rem;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background: var(--primary-dark);
        }

        /* ================= FIX NEWS IMAGE SIZE ================= */

        /* News list images */
        .news-card img {
            width: 100%;
            max-width: 300px;
            height: 200px;
            object-fit: cover;
            display: block;
            margin: 0 auto 10px;
            border-radius: 8px;
        }

        /* 🔥 SINGLE NEWS PAGE IMAGE (STRICT 500x500) */
        .news-detail-image,
        .news-detail img,
        .news-show img {
            width: 500px !important;
            height: 500px !important;
            max-width: 500px !important;
            max-height: 500px !important;
            object-fit: contain !important;
            display: block;
            margin: 20px auto;
            border-radius: 12px;
            background: #fff;
        }

        /* Prevent any image from breaking layout */
        .news-detail-image img {
            width: auto !important;
            height: auto !important;
            max-width: 100% !important;
            max-height: 100% !important;
            object-fit: contain;
        }

        /* Mobile fix */
        @media (max-width: 768px) {

            .news-detail-image,
            .news-detail img,
            .news-show img {
                width: 300px !important;
                height: 300px !important;
                max-width: 300px !important;
                max-height: 300px !important;
            }
        }
    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.documentElement;
        const toggleBtn = document.getElementById('themeToggle');

        // Detect saved or system theme
        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        const activeTheme = savedTheme ?? (systemDark ? 'dark' : 'light');
        root.setAttribute('data-theme', activeTheme);

        // Update icon
        toggleBtn.textContent = activeTheme === 'dark' ? '☀️' : '🌙';

        // Toggle click
        toggleBtn.addEventListener('click', () => {
            const isDark = root.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';

            root.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            toggleBtn.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        });

        // Listen to system changes ONLY if user didn't choose manually
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                const theme = e.matches ? 'dark' : 'light';
                root.setAttribute('data-theme', theme);
                toggleBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
            }
        });
    });
</script>


<body>

    <!-- NAVBAR ONLY -->
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('news.breaking') }}">Breaking News</a>
        <a href="{{ route('news.day') }}">News of the Day</a>
        <a href="{{ route('news.week') }}">News of the Week</a>

        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        <span id="live-datetime" style="margin-left:15px; font-weight:bold; font-size:14px;"></span>
        <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode">
            🌙
        </button>

    </nav>

    <nav>
        <ul>

            @guest
                <li><a href="{{ route('login') }}">Sign in</a></li>
                <li><a href="{{ route('register') }}">Sign up</a></li>
            @else
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout ({{ Auth::user()->name }})
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </nav>


    <!-- ✅ CONTENT IS COMPLETELY OUTSIDE NAVBAR -->
    <div class="content">
        @yield('content')
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');

            document.getElementById('live-datetime').textContent = `${hours}:${minutes}:${seconds} | ${day}/${month}`;
        }

        // Update every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // initial call
    </script>
    <select onchange="location=this.value">
        <option value="{{ url('lang/en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="{{ url('lang/ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}>پښتو</option>
        <option value="{{ url('lang/fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}>دری</option>

    </select>




</body>

</html>
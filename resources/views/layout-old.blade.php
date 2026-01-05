<!DOCTYPE html>
<html>

<head>
    <title>@yield('title') - TNM News</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* RESET */
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

        /* ================= PRIMARY NAV ================= */
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
            opacity: 0.85;
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

        /* DATETIME */
        #live-datetime {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            font-family: monospace;
        }

        /* THEME TOGGLE */
        .theme-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #fff;
            color: #fff;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all var(--transition);
        }

        .theme-toggle:hover {
            transform: rotate(20deg) scale(1.1);
        }

        /* ================= AUTH NAV ================= */
        nav:nth-of-type(2) {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 14px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--shadow-sm);
        }

        nav:nth-of-type(2) ul {
            list-style: none;
            display: flex;
            gap: 14px;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        /* AUTH BUTTONS (SAME STYLE) */
        .auth-btn {
            padding: 0.6rem 1.4rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            box-shadow: var(--shadow-md);
        }

        .auth-btn.secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        /* LOGOUT BUTTON */
        .logout-btn {
            padding: 0.6rem 1.4rem;
            border-radius: 999px;
            background: transparent;
            color: var(--danger);
            border: 2px solid var(--danger);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
        }

        .logout-btn:hover {
            background: var(--danger);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* LANGUAGE SELECT */
        select {
            margin-left: auto;
            padding: 0.6rem 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text);
            font-weight: 500;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* CONTENT */
        .content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
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

        /* MOBILE */
        @media (max-width: 768px) {
            nav:first-of-type {
                gap: 15px;
            }

            #live-datetime {
                display: none;
            }

            nav:nth-of-type(2) {
                flex-wrap: wrap;
            }

            select {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- PRIMARY NAV -->
    <nav>
        <a href="{{ route('home') }}">📰 Home</a>
        <a href="{{ route('news.breaking') }}">🔴 Breaking</a>
        <a href="{{ route('news.day') }}">📅 Day</a>
        <a href="{{ route('news.week') }}">📆 Week</a>
        <a href="{{ route('about') }}">ℹ️ About</a>
        <a href="{{ route('contact') }}">📧 Contact</a>
        <span id="live-datetime"></span>
        <button class="theme-toggle" id="themeToggle">🌙</button>
    </nav>

    <!-- AUTH NAV -->
    <nav>
        <ul>
            @guest
                <li>
                    <a href="{{ route('login') }}" class="auth-btn">Sign in</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="auth-btn secondary">Sign up</a>
                </li>
            @else
                <li>
                    <button class="logout-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout ({{ Auth::user()->name }})
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>

        <select onchange="location=this.value">
            <option value="{{ url('lang/en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="{{ url('lang/ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}>پښتو</option>
            <option value="{{ url('lang/fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}>دری</option>
        </select>
    </nav>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2026 TNM News. All rights reserved.</p>
    </footer>

    <script>
        function updateDateTime() {
            const n = new Date();
            document.getElementById('live-datetime').textContent =
                `${n.toLocaleTimeString()} | ${n.toLocaleDateString()}`;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        const root = document.documentElement;
        const toggleBtn = document.getElementById('themeToggle');
        const saved = localStorage.getItem('theme') ?? 'light';

        root.setAttribute('data-theme', saved);
        toggleBtn.textContent = saved === 'dark' ? '☀️' : '🌙';

        toggleBtn.onclick = () => {
            const t = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', t);
            localStorage.setItem('theme', t);
            toggleBtn.textContent = t === 'dark' ? '☀️' : '🌙';
        };
    </script>

</body>
</html>

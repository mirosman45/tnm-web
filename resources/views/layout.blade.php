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
            --shadow-xl: 0 14px 42px rgba(0, 0, 0, 0.18);
        }

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

        nav:first-of-type .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* --- BIG LOGO WITH FLOATING ANIMATION --- */
        nav:first-of-type .logo {
            height: 70px;
            width: auto;
            margin-right: 8px;
            vertical-align: middle;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        nav:first-of-type .nav-left a:first-child {
            display: flex;
            align-items: center;
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

        a[href="{{ route('admin.dashboard') }}"]:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 123, 255, .5);
            background: linear-gradient(135deg, #0056b3, #004494);
        }

        #themeChanger {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            color: #fff;
            font-size: 12px;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: transform .3s ease, box-shadow .3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        #themeChanger:hover {
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 4px 10px rgba(99, 102, 241, .45);
        }

        .btn-plain {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius);
            font-weight: 500;
            cursor: pointer;
            transition: border-color var(--transition), color var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .btn-plain:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            nav:first-of-type .nav-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            nav:first-of-type .logo {
                height: 60px;
            }

            nav:first-of-type a {
                font-size: 14px;
            }

            .logo-copy {
                height: 180px;
            }
        }

        /* Logo after second nav */
       .logo-copy {
    display: block;
    margin: 20px auto;
    height: 250px;   /* increased from 250px to 400px */
    max-width: 95%;  /* slightly larger max width */
    width: auto;
    animation: float 3s ease-in-out infinite;
}
@media (max-width: 768px) {
    .logo-copy {
        height: 300px;  /* bigger than previous 180px */
        max-width: 90%;
    }
}

        /* --- NEWS IMAGES RESPONSIVE --- */
        .content img,
        .news-content img {
            max-width: 100%;
            max-height: 80vh;
            width: auto;
            height: auto;
            display: block;
            margin: 15px auto;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>

    <!-- First Nav with Big Logo -->
    <nav>
        <div class="nav-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/tnm-logo.png') }}" class="logo" alt="TNM Logo">
                📰 {{ __('messages.home') }}
            </a>
            <a href="{{ route('news.breaking') }}">🔴 {{ __('messages.breaking_news') }}</a>
            <a href="{{ route('news.day') }}">📅 {{ __('messages.news_of_day') }}</a>
            <a href="{{ route('news.week') }}">📆 {{ __('messages.news_of_week') }}</a>
            <a href="{{ route('books.index') }}">📚 Books</a>
            <a href="{{ route('about') }}">ℹ️ {{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}">📧 {{ __('messages.contact') }}</a>
        </div>
        <span id="live-datetime"></span>
    </nav>

    <!-- Second Nav -->
    <nav>
        <ul>
            @guest
                <li><a href="{{ route('login') }}" class="btn-plain">{{ __('messages.login') }}</a></li>
                <li><a href="{{ route('register') }}" class="btn-plain">{{ __('messages.sign_up') }}</a></li>
            @endguest
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        style="position:relative; top:5px; left:30px; z-index:9999;
                        background:linear-gradient(135deg, #5537e8, #0056b3);
                        color:#fff; padding:7px 13px; border-radius:20px; text-decoration:none;
                        box-shadow:0 4px 15px rgba(0,123,255,.35); font-weight:600; font-size:14px;
                        letter-spacing:.4px; transition:all .3s ease; display:inline-flex; align-items:center; gap:6px;">
                        ⬅ Dashboard
                    </a>
                @endif
            @endauth
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

            <button id="themeChanger" title="Choose theme">⚙️</button>

            <select onchange="location=this.value">
                <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                <option value="{{ route('lang.switch', 'ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}>پښتو</option>
                <option value="{{ route('lang.switch', 'fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}>دری</option>
            </select>
        </div>
    </nav>

    <!-- Second copy of logo -->
    <img src="{{ asset('images/tnm-logo.png') }}" class="logo-copy" alt="TNM Logo">

    <div class="content">@yield('content')</div>

    <footer>
        <p>{{ __('messages.rights_reserved') }}</p>
    </footer>

    <div id="themeChooser"
        style="position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;display:flex;align-items:center;justify-content:center;">
        <div
            style="background:var(--surface);color:var(--text);padding:30px 40px;border-radius:var(--radius);box-shadow:var(--shadow-xl);text-align:center;max-width:320px;">
            <h3 style="margin-bottom:15px;">Choose your theme</h3>
            <p style="margin-bottom:25px;font-size:14px;color:var(--text-muted);">You can always change it later with
                the ⚙️ button in the header.</p>
            <div style="display:flex;gap:15px;justify-content:center;">
                <button onclick="saveTheme('light')"
                    style="flex:1;padding:10px;border-radius:var(--radius);border:2px solid var(--primary);background:#fff;color:var(--primary);font-weight:600;">☀️
                    Light</button>
                <button onclick="saveTheme('dark')"
                    style="flex:1;padding:10px;border-radius:var(--radius);border:2px solid var(--primary);background:var(--primary);color:#fff;font-weight:600;">🌙
                    Dark</button>
            </div>
        </div>
    </div>

    <script>
        const root = document.documentElement,
            chooser = document.getElementById('themeChooser');

        function applyTheme(t) {
            root.setAttribute('data-theme', t);
        }

        function saveTheme(t) {
            localStorage.setItem('tnm-theme', t);
            chooser.style.display = 'none';
            applyTheme(t);
        }

        (function () {
            const s = localStorage.getItem('tnm-theme');
            s ? (applyTheme(s), chooser.style.display = 'none') : (chooser.style.display = 'flex');
        })();

        function upd() {
            const n = new Date();
            document.getElementById('live-datetime').textContent = `${n.toLocaleTimeString()} | ${n.toLocaleDateString()}`;
        }

        setInterval(upd, 1000);
        upd();
        document.getElementById('themeChanger').addEventListener('click', () => chooser.style.display = 'flex');
    </script>

</body>

</html>

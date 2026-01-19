<!DOCTYPE html>
<html>

<head>
    <title>@yield('title') - TNM News</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --background: #e0e0e0; /* UPDATED: slightly darker gray */
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
            overflow-x: hidden;
            max-width: 100vw;
        }

        html {
            overflow-x: hidden;
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
            justify-content: space-between;
        }

        nav:first-of-type .nav-container {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            flex: 1;
            justify-content: space-between;
        }

        nav:first-of-type .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav:first-of-type .logo {
            height: 70px;
            width: auto;
            vertical-align: middle;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }

        nav:first-of-type .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        nav:first-of-type a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
        }

        nav:first-of-type a:hover {
            opacity: 0.85;
            transform: translateY(-2px);
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
            position: relative;
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
            flex-wrap: wrap;
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

        /* Date/Time moved to second nav */
        .datetime-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 20px;
        }

        #live-datetime {
            background: rgba(99, 102, 241, 0.15);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text);
            font-family: monospace;
            transition: var(--transition);
            white-space: nowrap;
            font-weight: 600;
            border: 1px solid var(--border);
        }

        #live-datetime:hover {
            background: rgba(99, 102, 241, 0.25);
            transform: translateY(-2px);
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
            min-height: 44px;
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
            min-width: 44px;
            min-height: 44px;
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
            min-height: 44px;
            min-width: 44px;
        }

        .btn-plain:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Logo after second nav */
        .logo-copy {
            display: block;
            height: 250px;
            max-width: 95%;
            width: auto;
            animation: float 3s ease-in-out infinite;
        }

        /* NEWS IMAGES RESPONSIVE */
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

        /* ==================== MOBILE RESPONSIVE FIXES ==================== */
        
        /* Tablet and below */
        @media (max-width: 768px) {
            /* First navigation - stacked layout */
            nav:first-of-type {
                padding: 12px 15px;
                gap: 15px;
                flex-direction: column;
                align-items: stretch;
            }
            
            nav:first-of-type .nav-container {
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }
            
            nav:first-of-type .logo-container {
                justify-content: center;
                width: 100%;
                margin-bottom: 10px;
            }
            
            nav:first-of-type .logo {
                height: 85px !important; /* BIGGER ON MOBILE */
                margin: 0;
            }
            
            nav:first-of-type .nav-links {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 10px;
                width: 100%;
                justify-content: center;
            }
            
            nav:first-of-type .nav-links a {
                text-align: center;
                padding: 8px 12px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 8px;
                font-size: 14px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            /* Second navigation - stacked */
            nav:nth-of-type(2) {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
            }
            
            nav:nth-of-type(2) ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                width: 100%;
                order: 1;
            }
            
            .social-lang-bar {
                margin-left: 0;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 15px;
                margin-top: 10px;
                order: 2;
            }
            
            .datetime-container {
                margin-left: 0;
                width: 100%;
                justify-content: center;
                order: 3;
                margin-top: 10px;
            }
            
            #live-datetime {
                width: 100%;
                text-align: center;
                font-size: 0.9rem;
                padding: 8px 16px;
                max-width: 300px;
            }
            
            .social-icons {
                gap: 15px;
                justify-content: center;
                width: 100%;
                order: 1;
            }
            
            .social-icons a {
                font-size: 1.4rem;
            }
            
            #themeChanger, select {
                order: 2;
            }
            
            /* Logo and welcome section - stacked vertically */
            body > div[style*="display:flex;align-items:center"] {
                flex-direction: column;
                text-align: center;
                padding: 20px 15px;
                margin-top: 10px;
                gap: 25px;
            }
            
            .logo-copy {
                height: 200px !important;
                max-width: 100% !important;
            }
            
            body > div[style*="display:flex;align-items:center"] > div[style*="max-width:520px"] {
                max-width: 100% !important;
                padding: 0 10px;
            }
            
            body > div[style*="display:flex;align-items:center"] h1 {
                font-size: 1.6rem !important;
                margin-bottom: 10px !important;
            }
            
            body > div[style*="display:flex;align-items:center"] p {
                font-size: 0.95rem !important;
                line-height: 1.5 !important;
            }
            
            /* Content area adjustments */
            .content {
                margin: 25px auto;
                padding: 0 15px;
            }
            
            /* Admin dashboard button - reposition */
            a[href="{{ route('admin.dashboard') }}"] {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                margin: 10px auto !important;
                display: block !important;
                width: fit-content !important;
                order: -1;
            }
            
            /* Theme chooser modal */
            #themeChooser > div[style*="max-width:320px"] {
                max-width: 90% !important;
                padding: 25px 20px !important;
                margin: 20px;
            }
            
            /* Footer */
            footer {
                padding: 25px 15px;
                margin-top: 40px;
                font-size: 0.9rem;
            }
            
            /* Ensure images in content don't overflow */
            .content img, .news-content img {
                max-height: 50vh !important;
                margin: 10px auto !important;
            }
        }

        /* Extra small devices (phones) */
        @media (max-width: 480px) {
            nav:first-of-type .nav-links {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            
            nav:first-of-type .nav-links a {
                font-size: 13px;
                padding: 7px 8px;
            }
            
            nav:first-of-type .logo {
                height: 80px !important; /* BIGGER ON SMALL PHONES */
            }
            
            .logo-copy {
                height: 160px !important;
            }
            
            body > div[style*="display:flex;align-items:center"] h1 {
                font-size: 1.4rem !important;
            }
            
            body > div[style*="display:flex;align-items:center"] p {
                font-size: 0.9rem !important;
            }
            
            .social-lang-bar {
                flex-direction: column;
                gap: 12px;
            }
            
            .datetime-container {
                order: 3;
                margin-top: 15px;
            }
            
            select {
                width: 100%;
                max-width: 200px;
            }
            
            #themeChanger {
                align-self: center;
            }
        }

        /* Small tablets (portrait) */
        @media (min-width: 481px) and (max-width: 768px) {
            nav:first-of-type .nav-links {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .logo-copy {
                height: 180px !important;
            }
            
            nav:first-of-type .logo {
                height: 90px !important; /* BIGGER ON TABLETS */
            }
        }

        /* Landscape mode adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            nav:first-of-type {
                padding: 8px 15px;
            }
            
            nav:first-of-type .nav-links {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .logo-copy {
                height: 120px !important;
            }
            
            nav:first-of-type .logo {
                height: 70px !important; /* Smaller in landscape */
            }
        }

        /* Desktop adjustments for date/time positioning */
        @media (min-width: 769px) {
            .datetime-container {
                margin-left: 20px;
            }
            
            #live-datetime {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>

    <!-- First Nav with Big Logo -->
    <nav>
        <div class="nav-container">
            <div class="logo-container">
                <img src="{{ asset('images/tnm-logo.png') }}" class="logo" alt="TNM Logo">
            </div>
            
          <div class="nav-links">
    <a href="{{ route('home') }}">📰 {{ __('messages.home') }}</a>
    <a href="{{ route('news.breaking') }}">🔴 {{ __('messages.breaking_news') }}</a>
    <a href="{{ route('news.day') }}">📅 {{ __('messages.news_of_day') }}</a>
    <a href="{{ route('news.week') }}">📆 {{ __('messages.news_of_week') }}</a>
    <!-- Add this line -->
    <a href="{{ route('events.index') }}">📅 Events</a>
    <a href="{{ route('books.index') }}">📚 Books</a>
    <a href="{{ route('about') }}">ℹ️ {{ __('messages.about') }}</a>
    <a href="{{ route('contact') }}">📧 {{ __('messages.contact') }}</a>
</div>
        </div>
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
        
        <div class="datetime-container">
            <span id="live-datetime"></span>
        </div>
    </nav>

   <div style="display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap;margin-top:20px;">
    <img src="{{ asset('images/tnm-logo.png') }}" class="logo-copy" alt="TNM Logo">

    <div style="max-width:520px;">
        <h1 style="font-size:2rem;margin-bottom:12px;color:var(--text);">
            {{ __('messages.home_welcome_title') }}
        </h1>
        <p style="font-size:1rem;color:var(--text-muted);line-height:1.6;">
            {{ __('messages.home_welcome_text') }}
        </p>
    </div>
</div>


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
<!DOCTYPE html>
<html>

<head>
    <title>{{ __('messages.admin_panel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: var(--background);
            color: var(--text);
        }

        /* Admin Header */
        .admin-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .admin-header .user-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .admin-header select {
            padding: 8px 12px;
            border-radius: var(--radius);
            border: 2px solid #fff;
            background: transparent;
            color: #fff;
            cursor: pointer;
            font-weight: 600;
        }

        .admin-header select option {
            color: var(--text);
            background: var(--surface);
        }

        .admin-header button {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 2px solid #fff;
            padding: 8px 15px;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition);
        }

        .admin-header button:hover {
            background: #fff;
            color: var(--primary);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: calc(100vh - 70px);
            background: var(--surface);
            position: fixed;
            top: 70px;
            left: 0;
            color: var(--text);
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid var(--border);
            box-shadow: var(--shadow-md);
        }

        .sidebar h3 {
            margin-bottom: 20px;
            font-size: 1.3rem;
            text-align: center;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
            font-weight: 700;
        }

        .sidebar a {
            display: block;
            color: var(--text);
            padding: 12px 15px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: var(--radius);
            transition: all var(--transition);
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background: var(--primary-light);
            border-left-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }

        /* Content */
        .content {
            margin-left: 270px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
            background: var(--background);
        }

        h1,
        h2,
        h3 {
            color: var(--text);
            margin-bottom: 15px;
            font-weight: 700;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: var(--surface);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        table th {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-weight: 600;
        }

        table tr:hover {
            background: var(--primary-light);
        }

        button,
        input[type="submit"] {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: var(--radius);
            cursor: pointer;
            transition: all var(--transition);
            font-weight: 600;
            box-shadow: var(--shadow-md);
        }

        button:hover,
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: var(--radius);
            border: 2px solid var(--border);
            margin-top: 5px;
            margin-bottom: 15px;
            background: var(--surface);
            color: var(--text);
            font-family: inherit;
            transition: all var(--transition);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Quick Stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stats .card {
            background: var(--surface);
            padding: 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            text-align: center;
            border-left: 4px solid var(--primary);
        }

        .stats .card h2 {
            font-size: 28px;
            margin-bottom: 5px;
            color: var(--primary);
        }

        .stats .card p {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 220px;
            }

            .admin-header {
                flex-direction: column;
                gap: 10px;
            }

            .admin-header .user-info {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>

    <!-- ADMIN HEADER -->
    <div class="admin-header">
        <h1>⚙️ {{ __('messages.admin_panel') }}</h1>
        <div class="user-info">
            <select onchange="location=this.value">
                <option value="{{ route('lang.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>
                    English</option>
                <option value="{{ route('lang.switch', 'ps') }}" {{ app()->getLocale() == 'ps' ? 'selected' : '' }}>پښتو
                </option>
                <option value="{{ route('lang.switch', 'fa') }}" {{ app()->getLocale() == 'fa' ? 'selected' : '' }}> دری
                </option>
            </select>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit">{{ __('messages.logout') }}</button>
            </form>
        </div>
    </div>

    <div class="sidebar">
        <h3>{{ __('messages.admin_panel') }}</h3>
        <a href="{{ route('admin.dashboard') }}">📊 {{ __('messages.dashboard') }}</a>
        <a href="{{ route('admin.users') }}">👥 {{ __('messages.manage_users') }}</a>
        <a href="{{ route('admin.news.index', ['type' => 'breaking']) }}">🔴 {{ __('messages.breaking_news') }}</a>
        <a href="{{ route('admin.news.index', ['type' => 'day']) }}">📅 {{ __('messages.news_of_day') }}</a>
        <a href="{{ route('admin.news.index', ['type' => 'week']) }}">📆 {{ __('messages.news_of_week') }}</a>
        <hr style="border-color: var(--border); margin: 15px 0;">
        <a href="{{ route('admin.news.create', ['type' => 'breaking']) }}">➕ {{ __('messages.add_news') }}
            ({{ __('messages.breaking') }})</a>
        <a href="{{ route('admin.news.create', ['type' => 'day']) }}">➕ {{ __('messages.add_news') }}
            ({{ __('messages.day') }})</a>
        <a href="{{ route('admin.news.create', ['type' => 'week']) }}">➕ {{ __('messages.add_news') }}
            ({{ __('messages.week') }})</a>
        <hr style="border-color: var(--border); margin: 15px 0;">
        <a href="{{ route('home') }}" style="color: var(--success);">👁️ {{ __('messages.view_site') }}</a>
    </div>

    <div class="content">
        @yield('content')
    </div>



</body>

</html>
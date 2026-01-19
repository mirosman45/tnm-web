<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.1);
            --secondary: #7c3aed;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --surface: #ffffff;
            --background: #f8fafc;
            --text: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --radius: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --surface: #1f2937;
            --background: #111827;
            --text: #f9fafb;
            --text-muted: #9ca3af;
            --border: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        /* Admin Header */
        .admin-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 64px;
        }

        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: var(--surface);
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            border-right: 1px solid var(--border);
            overflow-y: auto;
            padding: 1.5rem 1rem;
            transition: transform 0.3s ease;
            z-index: 900;
        }

        .admin-sidebar h3 {
            font-size: 0.875rem;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 1rem;
            padding-left: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar-nav a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-nav a.active {
            background: var(--primary);
            color: white;
        }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .admin-main {
            margin-left: 250px;
            margin-top: 64px;
            padding: 2rem;
            min-height: calc(100vh - 64px);
        }

        /* Cards */
        .admin-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .admin-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text);
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .admin-table th,
        .admin-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .admin-table th {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .admin-table tr:hover {
            background: var(--primary-light);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--background);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: var(--success);
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-color: var(--warning);
            color: #92400e;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .admin-header h1 span {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <h1>
            <span>⚙️</span>
            <span>{{ config('app.name', 'Laravel') }} Admin</span>
        </h1>
        
        <div class="admin-actions">
            @auth
            <div style="color: white; margin-right: 1rem;">
                {{ Auth::user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border-color: white;">
                    Logout
                </button>
            </form>
            @endauth
        </div>
    </header>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <nav class="sidebar-nav">
            <h3>Dashboard</h3>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>
            
            <h3>Users</h3>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                👥 Manage Users
            </a>
            
            <h3>News</h3>
            <a href="{{ route('admin.news.index', ['type' => 'breaking']) }}" class="{{ request()->routeIs('admin.news.index') && request()->type == 'breaking' ? 'active' : '' }}">
                🔴 Breaking News
            </a>
            <a href="{{ route('admin.news.index', ['type' => 'day']) }}" class="{{ request()->routeIs('admin.news.index') && request()->type == 'day' ? 'active' : '' }}">
                📅 News of Day
            </a>
            <a href="{{ route('admin.news.index', ['type' => 'week']) }}" class="{{ request()->routeIs('admin.news.index') && request()->type == 'week' ? 'active' : '' }}">
                📆 News of Week
            </a>
            
            <h3>Events</h3>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.index') ? 'active' : '' }}">
                📅 Manage Events
            </a>
            <a href="{{ route('admin.events.create') }}" class="{{ request()->routeIs('admin.events.create') ? 'active' : '' }}">
                ➕ Create Event
            </a>
            
            <h3>Website</h3>
            <a href="{{ route('home') }}" target="_blank">
                👁️ View Site
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Add mobile menu button
            const header = document.querySelector('.admin-header h1');
            const menuBtn = document.createElement('button');
            menuBtn.innerHTML = '☰';
            menuBtn.style.background = 'none';
            menuBtn.style.border = 'none';
            menuBtn.style.color = 'white';
            menuBtn.style.fontSize = '1.5rem';
            menuBtn.style.cursor = 'pointer';
            menuBtn.style.marginRight = '1rem';
            
            menuBtn.addEventListener('click', function() {
                document.querySelector('.admin-sidebar').classList.toggle('open');
            });
            
            header.insertBefore(menuBtn, header.firstChild);
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.querySelector('.admin-sidebar');
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile && sidebar.classList.contains('open') && 
                    !sidebar.contains(event.target) && 
                    !menuBtn.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>

</html>
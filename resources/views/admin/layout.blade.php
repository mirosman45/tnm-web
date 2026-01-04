<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1f2937;
            position: fixed;
            color: #fff;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h3 {
            margin-bottom: 20px;
            font-size: 22px;
            text-align: center;
            color: #fff;
            border-bottom: 1px solid #374151;
            padding-bottom: 10px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px 15px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #374151;
        }

        /* Content */
        .content {
            margin-left: 270px;
            padding: 30px;
            min-height: 100vh;
        }

        h1,
        h2,
        h3 {
            color: #111827;
            margin-bottom: 15px;
        }

        p {
            color: #4b5563;
            margin-bottom: 15px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        table th {
            background: #111827;
            color: #fff;
        }

        table tr:hover {
            background: #f3f4f6;
        }

        button {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1d4ed8;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #d1d5db;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        /* Quick Stats */
        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stats .card {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stats .card h2 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #111827;
        }

        .stats .card p {
            font-size: 16px;
            color: #6b7280;
        }

        /* Scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }
    </style>
</head>

<body>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="admin-logout-btn">
            Logout
        </button>
    </form>


    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.news.index', ['type' => 'breaking']) }}">Breaking News</a>
        <a href="{{ route('admin.news.index', ['type' => 'day']) }}">News of the Day</a>
        <a href="{{ route('admin.news.index', ['type' => 'week']) }}">News of the Week</a>
        <a href="{{ route('admin.news.create', ['type' => 'breaking']) }}">+ Add Breaking News</a>
        <a href="{{ route('admin.news.create', ['type' => 'day']) }}">+ Add News of the Day</a>
        <a href="{{ route('admin.news.create', ['type' => 'week']) }}">+ Add News of the Week</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>

</html>
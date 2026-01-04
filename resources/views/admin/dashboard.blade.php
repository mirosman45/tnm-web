@extends('admin.layout')

@section('content')
    <h1>Welcome to Admin Dashboard</h1>
    <p>Use the sidebar to manage News content.</p>

    <div style="margin-top:20px;">
        <h3>Quick Stats</h3>
        <ul>
            <li><a href="{{ route('admin.users') }}">Users</a>
            </li>
            <li>Total Breaking News: {{ \App\Models\News::where('type', 'breaking')->count() }}</li>
            <li>Total News of the Day: {{ \App\Models\News::where('type', 'day')->count() }}</li>
            <li>Total News of the Week: {{ \App\Models\News::where('type', 'week')->count() }}</li>
        </ul>
    </div>
@endsection
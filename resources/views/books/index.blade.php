@extends('layout')

@section('title', 'Books')

@section('content')
<div class="content">
    <h1>📚 Books Library</h1>

    @if(session('success'))
        <div style="color:green; background: #d4edda; padding: 15px; border-radius: 4px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color:red; background: #f8d7da; padding: 15px; border-radius: 4px; margin-bottom: 20px;">{{ session('error') }}</div>
    @endif

    {{-- Show registration/login prompt for unauthenticated users --}}
    @guest
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
            <h2 style="color: white; border: none; padding: 0; margin-bottom: 15px;">Welcome to Our Books Library! 📖</h2>
            <p style="color: rgba(255, 255, 255, 0.95); margin-bottom: 20px;">Create an account or login to download and share books with the community.</p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" style="background: white; color: #667eea; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">Register Now</a>
                <a href="{{ route('login') }}" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; border: 2px solid white;">Login</a>
            </div>
        </div>
    @endguest

    {{-- Search Form --}}
    <form method="GET" action="{{ route('books.index') }}" style="margin-bottom: 20px;">
        <div style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search books by title..." value="{{ $search }}" 
                   style="padding: 0.5rem; flex: 3; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; flex: 1;">Search</button>
            @if($search)
                <a href="{{ route('books.index') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; flex: 1; text-decoration: none; background: #6c757d; color: white; border-radius: 4px;">Clear</a>
            @endif
        </div>
    </form>

    <h3 style="margin-top: 30px; margin-bottom: 20px;">📖 Available Books</h3>

    <table style="width:100%; margin-top:20px; border-collapse: collapse;">
        <tr style="background: #f8f9fa;">
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">📖 Title</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Actions</th>
        </tr>
        @forelse($books as $book)
            <tr style="hover-background: #f5f5f5;">
                <td style="border: 1px solid #ddd; padding: 12px;">{{ $book->title }}</td>
                <td style="border: 1px solid #ddd; padding: 12px; display:flex; gap:10px; flex-wrap: wrap;">
                    @auth
                        {{-- Authenticated user - show download button --}}
                        <a href="{{ route('books.download', $book->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; background: #007bff; color: white; text-decoration: none; border-radius: 4px;">⬇️ Download</a>
                    @else
                        {{-- Not authenticated - show login prompt for download --}}
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="color: #666;">Login to download</span>
                            <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; background: #007bff; color: white; text-decoration: none; border-radius: 4px;">Login</a>
                        </div>
                    @endauth
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" style="border: 1px solid #ddd; padding: 20px; text-align: center; color: #999;">
                    📭 No books found yet.
                </td>
            </tr>
        @endforelse
    </table>

    @if($books->count() > 0)
        <p style="margin-top: 20px; color: #666; text-align: center;">📚 Total books available: <strong>{{ $books->count() }}</strong></p>
    @endif
</div>
@endsection

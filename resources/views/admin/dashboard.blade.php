@extends('admin.layout')

@section('content')
    <h1>{{ __('messages.welcome') }} - {{ __('messages.admin_panel') }}</h1>
    <p>{{ __('messages.manage_news') }}</p>

    @if(session('success'))
        <div style="color:green; background: #d4edda; padding: 15px; border-radius: 4px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color:red; background: #f8d7da; padding: 15px; border-radius: 4px; margin-bottom: 20px;">{{ session('error') }}</div>
    @endif

    <div style="margin-top:20px;">
        <h3>Quick Stats</h3>
        <ul>
            <li><a href="{{ route('admin.users') }}">{{ __('messages.users') }}</a></li>
            <li>Total Breaking News: {{ \App\Models\News::where('type', 'breaking')->count() }}</li>
            <li>Total News of the Day: {{ \App\Models\News::where('type', 'day')->count() }}</li>
            <li>Total News of the Week: {{ \App\Models\News::where('type', 'week')->count() }}</li>
            <li>📚 Total Books: {{ count($books) }}</li>
        </ul>
    </div>

    <!-- Books Management Section -->
    <div style="margin-top: 40px; background: #f8f9fa; border: 2px solid #28a745; border-radius: 8px; padding: 25px;">
        <h2 style="color: #28a745; border: none; padding: 0; margin-bottom: 20px;">📚 Books Management</h2>
        
        {{-- Upload Form --}}
        <div style="margin-bottom: 30px; background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
            <h3 style="color: #333; border: none; padding: 0; margin-bottom: 15px;">➕ Upload New Book</h3>
            
            @if ($errors->any())
                <div style="color:red; background: #f8d7da; padding: 15px; border-radius: 4px; margin-bottom: 15px;">
                    <ul style="margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Book Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter book title" required 
                               style="padding: 0.75rem; width: 100%; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">PDF File (Max 10MB)</label>
                        <input type="file" name="pdf" accept="application/pdf" required 
                               style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; display: block; box-sizing: border-box;">
                    </div>
                </div>

                <button type="submit" style="padding: 0.75rem 2rem; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">📤 Upload Book</button>
            </form>
        </div>

        {{-- Books List --}}
        <div>
            <h3 style="color: #333; border: none; padding: 0; margin-bottom: 15px;">📖 All Books</h3>
            
            @if($books->count() > 0)
                <table style="width:100%; border-collapse: collapse;">
                    <tr style="background: #e9ecef;">
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Title</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Uploaded By</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Date</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Actions</th>
                    </tr>
                    @foreach($books as $book)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 12px;">{{ $book->title }}</td>
                            <td style="border: 1px solid #ddd; padding: 12px;">{{ $book->user ? $book->user->name : 'Unknown' }}</td>
                            <td style="border: 1px solid #ddd; padding: 12px;">{{ $book->created_at->format('M d, Y') }}</td>
                            <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 0.5rem 1rem; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p style="color: #999; text-align: center; padding: 20px;">No books uploaded yet.</p>
            @endif
        </div>
    </div>
@endsection
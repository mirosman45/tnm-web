@extends('layout')

@section('title', __('messages.upload_book'))

@section('content')
<div class="content" style="max-width: 600px; margin: 0 auto;">
    <h1>{{ __('messages.upload_book') }}</h1>

    @if ($errors->any())
        <div style="color:red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">{{ __('messages.book_title') }}</label>
            <input type="text" name="title" value="{{ old('title') }}" required 
                   style="padding: 0.75rem; width: 100%; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">{{ __('messages.upload_pdf') }}</label>
            <input type="file" name="pdf" accept="application/pdf" required 
                   style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; display: block;">
            <small style="color: #666; margin-top: 5px;">Maximum file size: 10MB</small>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="auth-btn" style="padding: 0.75rem 2rem;">{{ __('messages.upload') }}</button>
            <a href="{{ route('books.index') }}" style="padding: 0.75rem 2rem; background: #6c757d; color: white; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection

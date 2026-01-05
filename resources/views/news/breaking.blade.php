@extends('layout')

@section('title', __('messages.breaking_news'))

@section('content')
    <div class="news-section">
        <h1 style="display: flex; align-items: center; gap: 10px;">🔴 {{ __('messages.breaking_news') }}</h1>
        <p style="font-size: 1.1rem; margin-bottom: 30px;">{{ __('messages.stay_tuned') }}</p>
        
        @if($news->isEmpty())
            <div style="text-align: center; padding: 50px 20px;">
                <p style="font-size: 1.2rem; color: var(--text-muted);">📭 {{ __('messages.no_news') }}</p>
            </div>
        @else
            <div class="grid">
                @foreach($news as $item)
                    <div class="news-card">
                        <a href="{{ route('news.show', $item->id) }}" class="news-link">
                            @if($item->image)
                                <div class="news-image">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                </div>
                            @else
                                <div class="news-image" style="background: linear-gradient(135deg, var(--primary-light), #f0f9ff); display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size: 3rem;">📰</span>
                                </div>
                            @endif
                            <div class="news-content">
                                <p class="date">{{ $item->created_at->format('d M Y') }}</p>
                                <h3>{{ $item->title }}</h3>
                                <p>{{ Str::limit($item->content, 120) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
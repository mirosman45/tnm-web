@extends('layout')

@section('title', __('messages.news_of_week'))

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="news-section">
        <h2>📆 {{ __('messages.news_of_week') }}</h2>
        <p style="font-size: 1.1rem; margin-bottom: 30px;">{{ __('messages.summary_week') }}</p>
        
        @if($newsItems->isEmpty())
            <div style="text-align: center; padding: 50px 20px;">
                <p style="font-size: 1.2rem; color: var(--text-muted);">📭 {{ __('messages.no_news_week') }}</p>
            </div>
        @else
            <div class="grid">
                @foreach($newsItems as $news)
                    <div class="news-card">
                        <a href="{{ route('news.show', $news->id) }}" class="news-link">
                            @if($news->image)
                                <div class="news-image">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                                </div>
                            @else
                                <div class="news-image" style="background: linear-gradient(135deg, var(--primary-light), #f0f9ff); display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size: 3rem;">📰</span>
                                </div>
                            @endif
                            <div class="news-content">
                                <p class="date">{{ $news->created_at->format('d M Y') }}</p>
                                <h3>{{ $news->title }}</h3>
                                <p>{{ Str::limit($news->content, 120) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
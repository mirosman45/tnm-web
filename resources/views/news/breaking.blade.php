@extends('layout')

@section('title', __('messages.breaking_news'))

@section('content')
<div class="news-section">
    {{-- Header --}}
    <h1 class="section-title">🔴 {{ __('messages.breaking_news') }}</h1>
    <p class="section-subtitle">{{ __('messages.stay_tuned') }}</p>

    {{-- Empty State --}}
    @if($news->isEmpty())
        <div class="empty-section">
            <p>📭 {{ __('messages.no_news') }}</p>
        </div>
    @else
        {{-- Breaking News List --}}
        @foreach($news as $item)
            <div class="breaking-news">
                <a href="{{ route('news.show', $item->id) }}" class="breaking-news-link">
                    
                    {{-- Text --}}
                    <div class="breaking-news-content">
                        <p class="date">{{ $item->created_at->format('d M Y') }}</p>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ Str::limit($item->content, 200) }}</p>
                    </div>

                    {{-- Image --}}
                    <div class="breaking-news-image">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        @else
                            <div class="no-image">
                                <span style="font-size: 3rem;">🔴</span>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>
@endsection

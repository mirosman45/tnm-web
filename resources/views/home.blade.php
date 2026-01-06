@extends('layout')

@section('title', 'Home')

@section('content')
@php use Illuminate\Support\Str; @endphp

{{-- ================= BREAKING NEWS ================= --}}
<div class="news-section">
    <h2>🔴 {{ __('messages.breaking_news') }}</h2>

    @if($breaking)
        <div class="news-card breaking-news">
            <a href="{{ route('news.show', $breaking->id) }}" class="news-link">
                @if($breaking->image)
                    <div class="news-image">
                        <img src="{{ asset('storage/' . $breaking->image) }}" alt="{{ $breaking->title }}">
                    </div>
                @else
                    <div class="news-image no-image">
                        <span style="font-size: 3rem;">🔴</span>
                    </div>
                @endif

                <div class="news-content">
                    <p class="date text-danger">{{ $breaking->created_at->format('d M Y') }}</p>
                    <h3>{{ $breaking->title }}</h3>
                    <p>{{ Str::limit($breaking->content, 200) }}</p>
                </div>
            </a>
        </div>
    @else
        <div class="empty-section">
            <p>{{ __('messages.no_breaking_news') }}</p>
        </div>
    @endif
</div>

{{-- ================= NEWS OF THE DAY ================= --}}
<div class="news-section">
    <h2>📅 {{ __('messages.news_of_day') }}</h2>

    @if($day->isEmpty())
        <div class="empty-section">
            <p>{{ __('messages.no_news_day') }}</p>
        </div>
    @else
        <div class="grid">
            @foreach($day as $d)
                <div class="news-card">
                    <a href="{{ route('news.show', $d->id) }}" class="news-link">
                        @if($d->image)
                            <div class="news-image">
                                <img src="{{ asset('storage/' . $d->image) }}" alt="{{ $d->title }}">
                            </div>
                        @else
                            <div class="news-image no-image">
                                <span style="font-size: 3rem;">📰</span>
                            </div>
                        @endif
                        <div class="news-content">
                            <p class="date">{{ $d->created_at->format('d M Y') }}</p>
                            <h3>{{ $d->title }}</h3>
                            <p>{{ Str::limit($d->content, 120) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ================= NEWS OF THE WEEK ================= --}}
<div class="news-section">
    <h2>📆 {{ __('messages.news_of_week') }}</h2>

    @if($week->isEmpty())
        <div class="empty-section">
            <p>{{ __('messages.no_news_week') }}</p>
        </div>
    @else
        <div class="grid">
            @foreach($week as $w)
                <div class="news-card">
                    <a href="{{ route('news.show', $w->id) }}" class="news-link">
                        @if($w->image)
                            <div class="news-image">
                                <img src="{{ asset('storage/' . $w->image) }}" alt="{{ $w->title }}">
                            </div>
                        @else
                            <div class="news-image no-image">
                                <span style="font-size: 3rem;">📰</span>
                            </div>
                        @endif
                        <div class="news-content">
                            <p class="date">{{ $w->created_at->format('d M Y') }}</p>
                            <h3>{{ $w->title }}</h3>
                            <p>{{ Str::limit($w->content, 120) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

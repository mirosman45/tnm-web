@extends('layout')

@section('title', 'Home')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    {{-- ================= Breaking News ================= --}}
    <div class="news-section">
        <h2>Breaking News</h2>

        @if($breaking)
            <div class="news-card">
                <a href="{{ route('news.show', $breaking->id) }}" class="news-link">

                    {{-- Image on TOP --}}
                    @if($breaking->image)
                        <div class="news-image">
                            <img src="{{ asset('storage/' . $breaking->image) }}" alt="{{ $breaking->title }}">
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="news-content">
                        <p class="date">{{ $breaking->created_at->format('d M Y') }}</p>
                        <h3>{{ $breaking->title }}</h3>
                        <p>{{ $breaking->content }}</p>
                    </div>

                </a>
            </div>
        @else
            <p>No breaking news available.</p>
        @endif
    </div>

    {{-- ================= News of the Day ================= --}}
    <div class="news-section">
        <h2>News of the Day</h2>

        <div class="grid">
            @forelse($day as $d)
                <div class="news-card">
                    <a href="{{ route('news.show', $d->id) }}" class="news-link">

                        {{-- Image on TOP --}}
                        @if($d->image)
                            <div class="news-image">
                                <img src="{{ asset('storage/' . $d->image) }}" alt="{{ $d->title }}">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="news-content">
                            <p class="date">{{ $d->created_at->format('d M Y') }}</p>
                            <h3>{{ $d->title }}</h3>
                            <p>{{ Str::limit($d->content, 120) }}</p>
                        </div>

                    </a>
                </div>
            @empty
                <p>No news of the day available.</p>
            @endforelse
        </div>
    </div>

    {{-- ================= News of the Week ================= --}}
    <div class="news-section">
        <h2>News of the Week</h2>

        <div class="grid">
            @forelse($week as $w)
                <div class="news-card">
                    <a href="{{ route('news.show', $w->id) }}" class="news-link">

                        {{-- Image on TOP --}}
                        @if($w->image)
                            <div class="news-image">
                                <img src="{{ asset('storage/' . $w->image) }}" alt="{{ $w->title }}">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="news-content">
                            <p class="date">{{ $w->created_at->format('d M Y') }}</p>
                            <h3>{{ $w->title }}</h3>
                            <p>{{ Str::limit($w->content, 120) }}</p>
                        </div>

                    </a>
                </div>
            @empty
                <p>No news of the week available.</p>
            @endforelse
        </div>
    </div>

@endsection
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
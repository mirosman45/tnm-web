@extends('layout')

@section('title', $title)

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="news-section">
        <h2>{{ $title }}</h2>

        @if($newsItems->isEmpty())
            <p>No news available.</p>
        @else
            <div class="grid">
                @foreach($newsItems as $news)
                    <div class="news-card">
                        <a href="{{ route('news.show', $news->id) }}" class="news-link">
                            <div class="news-content">
                                <p class="date">{{ $news->created_at->format('d M Y') }}</p>
                                <h3>{{ $news->title }}</h3>
                                <p>{{ Str::limit($news->content, 120) }}</p>
                            </div>
                            @if($news->image)
                                <div class="news-image">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
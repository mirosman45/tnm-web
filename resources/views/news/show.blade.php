@extends('layout')

@section('title', $news->title)

@section('content')
    <div class="news-single-container">

        <h1 class="news-title">{{ $news->title }}</h1>

        <p class="news-date">📅 {{ $news->created_at->format('d M Y') }}</p>

        @if($news->image)
            <div class="news-image-wrapper">
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" loading="lazy">
            </div>
        @endif

        <div class="news-content">
            {!! nl2br(e($news->content)) !!}
        </div>

        {{-- Like/Dislike Section --}}
        <div class="news-likes">
            <form action="{{ route('news.like', $news->id) }}" method="POST">
                @csrf
                <button type="submit" name="is_like" value="1" class="btn btn-success">
                    👍 {{ __('messages.like') }} ({{ $news->likesCount() }})
                </button>
            </form>

            <form action="{{ route('news.like', $news->id) }}" method="POST">
                @csrf
                <button type="submit" name="is_like" value="0" class="btn btn-danger">
                    👎 {{ __('messages.dislike') }} ({{ $news->dislikesCount() }})
                </button>
            </form>
        </div>

        {{-- Comments Section --}}
        <div class="news-comments">
            <h3>💬 {{ __('messages.comments') }} ({{ $news->comments()->count() }})</h3>

            @auth
                <form action="{{ route('comments.store', $news->id) }}" method="POST">
                    @csrf
                    <textarea name="comment" rows="4" class="form-control" placeholder="{{ __('messages.write_comment') }}" required></textarea>
                    <button type="submit" class="btn btn-primary" style="margin-top: 15px;">{{ __('messages.post_comment') }}</button>
                </form>
            @else
                <p style="color: var(--text-muted); margin: 20px 0;"><a href="{{ route('login') }}" style="color: var(--primary); text-decoration: underline;">{{ __('messages.login') }}</a> {{ __('messages.login_to_comment') }}</p>
            @endauth

            <div class="comments-list" style="margin-top: 30px;">
                @forelse($news->comments as $comment)
                    <div class="comment">
                        <p>
                            <strong>{{ $comment->user->name }}</strong>
                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p style="color: var(--text-muted); text-align: center; margin: 30px 0;">{{ __('messages.no_comments') }}</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
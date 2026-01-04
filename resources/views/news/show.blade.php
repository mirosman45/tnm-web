@extends('layout')

@section('title', $news->title)

@section('content')
    <div class="news-single-container">

        <h1 class="news-title">{{ $news->title }}</h1>

        <p class="news-date">{{ $news->created_at->format('d M Y') }}</p>

        @if($news->image)
            <div class="news-image-wrapper">
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" loading="lazy">
            </div>
        @endif

        <div class="news-content">
            {!! nl2br(e($news->content)) !!}
        </div>

        {{-- Like/Dislike Section --}}
        <div class="news-likes mt-4">
            <form action="{{ route('news.like', $news->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" name="is_like" value="1" class="btn btn-success">
                    👍 Like ({{ $news->likesCount() }})
                </button>
            </form>

            <form action="{{ route('news.like', $news->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" name="is_like" value="0" class="btn btn-danger">
                    👎 Dislike ({{ $news->dislikesCount() }})
                </button>
            </form>
        </div>

        {{-- Comments Section --}}
        <div class="news-comments mt-5">
            <h3>Comments ({{ $news->comments()->count() }})</h3>

            @auth
                <form action="{{ route('comments.store', $news->id) }}" method="POST">
                    @csrf
                    <textarea name="comment" rows="3" class="form-control" placeholder="Write your comment..."
                        required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Login</a> to comment or like/dislike this news.</p>
            @endauth

            <div class="comments-list mt-4">
                @foreach($news->comments as $comment)
                    <div class="comment mb-3 p-2 border rounded">
                        <p><strong>{{ $comment->user->name }}</strong>
                            <small>{{ $comment->created_at->diffForHumans() }}</small></p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
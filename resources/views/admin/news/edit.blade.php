@extends('admin.layout')

@section('content')
    <h2>Edit News</h2>

    <form method="POST" action="{{ route('admin.news.update', $news->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Title:</label><br>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" required>
        </div>

        <div>
            <label>Content:</label><br>
            <textarea name="content" rows="5" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label>Type:</label><br>
            <select name="type" required>
                <option value="breaking" {{ $news->type == 'breaking' ? 'selected' : '' }}>Breaking</option>
                <option value="day" {{ $news->type == 'day' ? 'selected' : '' }}>Day</option>
                <option value="week" {{ $news->type == 'week' ? 'selected' : '' }}>Week</option>
            </select>
        </div>

        <br>
        <button type="submit">Update News</button>
    </form>
@endsection
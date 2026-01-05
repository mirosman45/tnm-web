@extends('admin.layout')

@section('content')
    <h2>{{ __('messages.edit') }} {{ __('messages.news_item') }}</h2>

    <form method="POST" action="{{ route('admin.news.update', $news->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>{{ __('messages.news_title') }}:</label><br>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" required>
        </div>

        <div>
            <label>{{ __('messages.news_content') }}:</label><br>
            <textarea name="content" rows="5" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label>{{ __('messages.type') }}:</label><br>
            <select name="type" required>
                <option value="breaking" {{ $news->type == 'breaking' ? 'selected' : '' }}>{{ __('messages.breaking') }}</option>
                <option value="day" {{ $news->type == 'day' ? 'selected' : '' }}>{{ __('messages.day') }}</option>
                <option value="week" {{ $news->type == 'week' ? 'selected' : '' }}>{{ __('messages.week') }}</option>
            </select>
        </div>

        <br>
        <button type="submit" class="btn btn-success">{{ __('messages.update') }}</button>
    </form>
@endsection
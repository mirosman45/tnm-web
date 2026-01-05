@extends('admin.layout')

@section('content')
    <h2>{{ __('messages.add_news') }} - {{ __('messages.' . $type) }}</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="text" name="title" placeholder="{{ __('messages.news_title') }}" required>

        <textarea name="content" placeholder="{{ __('messages.news_content') }}" required></textarea>

        <select name="type" required>
            <option value="breaking">{{ __('messages.breaking_news') }}</option>
            <option value="day">{{ __('messages.news_of_day') }}</option>
            <option value="week">{{ __('messages.news_of_week') }}</option>
        </select>

        <input type="date" name="publish_date" required>

        <input type="file" name="image" accept="image/*">

        <button type="submit">{{ __('messages.save') }}</button>
    </form>


    @if ($errors->any())
        <div style="color:red">
            {{ $errors->first() }}
        </div>
    @endif

@endsection
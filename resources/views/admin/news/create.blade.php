@extends('admin.layout')

@section('content')
    <h2>Add {{ ucfirst($type) }} News</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="text" name="title" placeholder="Title" required>

        <textarea name="content" placeholder="Content" required></textarea>

        <select name="type" required>
            <option value="breaking">Breaking News</option>
            <option value="day">News of the Day</option>
            <option value="week">News of the Week</option>
        </select>

        <input type="date" name="publish_date" required>

        <input type="file" name="image" accept="image/*">

        <button type="submit">Save</button>
    </form>


    @if ($errors->any())
        <div style="color:red">
            {{ $errors->first() }}
        </div>
    @endif

@endsection
@extends('admin.layout')

@section('content')
    <h2>{{ ucfirst($type) }} News</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.news.create', ['type' => $type]) }}">+ Add New</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Actions</th>
            <th>Edit</th>
        </tr>
        @foreach($news as $n)
            <tr>
                <td>{{ $n->id }}</td>
                <td>{{ $n->title }}</td>
                <td>{{ $n->content }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.news.destroy', $n->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('admin.news.edit', $n->id) }}">
                        <button>Edit</button>
                    </a>



            </tr>
        @endforeach
    </table>
@endsection
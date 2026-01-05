@extends('admin.layout')

@section('content')
    <h2>{{ __('messages.' . $type) }} {{ __('messages.news_list') }}</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.news.create', ['type' => $type]) }}" class="btn btn-primary" style="margin-bottom: 20px; display: inline-block;">➕ {{ __('messages.add_news') }}</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.news_title') }}</th>
                <th>{{ __('messages.news_content') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($news as $n)
                <tr>
                    <td>{{ $n->id }}</td>
                    <td>{{ $n->title }}</td>
                    <td>{{ Str::limit($n->content, 50) }}</td>
                    <td style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.news.edit', $n->id) }}">
                            <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.9rem;">{{ __('messages.edit') }}</button>
                        </a>
                        <form method="POST" action="{{ route('admin.news.destroy', $n->id) }}" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')" style="padding: 6px 12px; font-size: 0.9rem;">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
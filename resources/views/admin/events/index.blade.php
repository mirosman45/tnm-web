@extends('layout')

@section('title', 'Manage Events')

@section('content')
<div style="max-width:1000px;margin:50px auto;">
    <a href="{{ route('admin.events.create') }}" class="btn-plain" style="margin-bottom:20px;">+ Add Event</a>

    @if(session('success'))
        <p style="color:green;margin-bottom:15px;">{{ session('success') }}</p>
    @endif

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:1px solid var(--border);">
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr style="border-bottom:1px solid var(--border);">
                <td>{{ $event->title }}</td>
                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y, g:i A') }}</td>
                <td>{{ ucfirst($event->status) }}</td>
                <td style="display:flex;gap:10px;">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn-plain">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-plain" style="color:red;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:20px;">{{ $events->links() }}</div>
</div>
@endsection

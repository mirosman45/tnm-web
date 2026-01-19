@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="admin-container">
    <h1>Manage Events</h1>
    
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Add New Event</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(isset($events) && $events->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->date->format('M d, Y') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->status }}</td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <!-- Debug: Show event ID in form -->
                        <form action="{{ route('admin.events.toggle-status', $event) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Change status?')">
                                {{ $event->status === 'published' ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                        
                        <!-- Debug link -->
                        <a href="/debug-event/{{ $event->id }}" class="btn btn-sm btn-info" target="_blank">Debug</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $events->links() }}
    @else
        <p>No events found.</p>
    @endif
</div>
@endsection
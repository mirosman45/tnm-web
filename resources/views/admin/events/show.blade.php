@extends('layouts')

@section('title', $event->title)

@section('content')
    <h1>{{ $event->title }}</h1>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y, g:i A') }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p>{!! nl2br(e($event->description)) !!}</p>

    @auth
        <form action="{{ route('events.register', $event) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn-plain">Register</button>
        </form>

        <form action="{{ route('events.save', $event) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn-plain">Save</button>
        </form>
    @endauth

    <a href="{{ route('events.index') }}" style="display:block; margin-top:20px;">← Back to Events</a>
@endsection

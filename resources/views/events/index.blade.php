@extends('layout')

@section('title', __('Events'))

@section('content')

<!-- Events Section -->
<div style="max-width:1000px; margin:50px auto; padding:20px; background:rgba(255,255,255,0.05); border-radius:12px; box-shadow:var(--shadow-md);">

    <h1 style="font-size:2rem; margin-bottom:20px; color:var(--text);">
        Upcoming Events
    </h1>

    @if($events->isEmpty())
        <p style="line-height:1.6; color:var(--text-muted);">
            No upcoming events at the moment. Please check back later!
        </p>
    @else
        @foreach($events as $event)
            <div style="margin-bottom:25px; padding:15px; border:1px solid var(--border); border-radius:12px; background:var(--surface); box-shadow:var(--shadow-sm); transition:var(--transition);">

                <!-- Event Image -->
                @if($event->image)
                    <img src="{{ asset('storage/events/' . $event->image) }}" 
                         alt="{{ $event->title }}" 
                         style="width:100%; max-height:300px; object-fit:cover; border-radius:12px; margin-bottom:15px;">
                @endif

                <!-- Event Title -->
                <h2 style="font-size:1.5rem; color:var(--primary); margin-bottom:10px;">
                    <a href="{{ route('events.show', $event) }}" style="text-decoration:none; color:var(--primary);">
                        {{ $event->title }}
                    </a>
                </h2>

                <!-- Event Date -->
                <p style="margin-bottom:8px; color:var(--text-muted);">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y, g:i A') }}
                </p>

                <!-- Event Description -->
                <p style="margin-bottom:10px; line-height:1.6; color:var(--text-muted);">
                    {{ Str::limit($event->description, 200) }}
                </p>

                <!-- View Details Button -->
                <a href="{{ route('events.show', $event) }}" class="btn-plain">View Details</a>
            </div>
        @endforeach
    @endif

</div>

@endsection

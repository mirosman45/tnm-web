<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Show upcoming events for public users
     */
    public function index()
    {
        $events = Event::where('status', 'published')      // Only published
            ->whereDate('event_date', '>=', now())        // Upcoming
            ->orderBy('event_date', 'asc')
            ->get();                                      // Get all upcoming events

        return view('events.index', compact('events'));
    }

    /**
     * Show past events (optional)
     */
    public function pastEvents()
    {
        $events = Event::where('status', 'published')
            ->whereDate('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->get();

        return view('events.past', compact('events'));
    }

    /**
     * Show single event details
     */
    public function show(Event $event)
    {
        if ($event->status !== 'published') {
            abort(404); // only allow published events
        }

        return view('events.show', compact('event'));
    }

    /**
     * Register user for event (auth only)
     */
    public function register(Event $event)
    {
        // Add logic later if you want to save registrations
        return back()->with('success', 'You have registered for this event.');
    }

    /**
     * Save event for later (auth only)
     */
    public function save(Event $event)
    {
        // Add logic later for "save/favorites"
        return back()->with('success', 'Event saved successfully.');
    }
}

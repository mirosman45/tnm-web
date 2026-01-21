<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * List all events
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store new event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'event_date'  => 'required|date',
            'status'      => 'required|in:draft,published',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->status = $request->status;

        // ✅ IMAGE UPLOAD (FIX)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/events');
            $event->image = basename($path); // IMPORTANT
        }

        $event->save();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update event
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'event_date'  => 'required|date',
            'status'      => 'required|in:draft,published',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event->title = $request->title;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->status = $request->status;

        // ✅ IMAGE UPDATE
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/events');
            $event->image = basename($path);
        }

        $event->save();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Event deleted successfully');
    }

    /**
     * Toggle publish status
     */
    public function toggleStatus(Event $event)
    {
        $event->status = $event->status === 'published' ? 'draft' : 'published';
        $event->save();

        return back()->with('success', 'Event status updated');
    }
}

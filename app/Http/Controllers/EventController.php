<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of events for public.
     */
    public function index()
    {
        $events = Event::where('status', 'published')
            ->where(function($query) {
                $query->where('date', '>', now()->toDateString())
                      ->orWhere(function($q) {
                          $q->whereDate('date', now()->toDateString())
                            ->where(function($subQuery) {
                                $subQuery->whereNull('time')
                                       ->orWhere('time', '>=', now()->format('H:i:s'));
                            });
                      });
            })
            ->orderBy('date', 'asc')
            ->orderByRaw('ISNULL(time), time asc')
            ->paginate(9);

        return view('events.index', compact('events'));
    }

    /**
     * Display the specified event for public.
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $event->increment('views');

        // Parse JSON fields for display
        if ($event->speakers) {
            $event->speakers_list = is_string($event->speakers) 
                ? json_decode($event->speakers, true) 
                : $event->speakers;
        }
        
        if ($event->agenda) {
            $event->agenda_list = is_string($event->agenda) 
                ? json_decode($event->agenda, true) 
                : $event->agenda;
        }

        return view('events.show', compact('event'));
    }

    /**
     * ============================================
     * ADMIN METHODS - Event Management
     * ============================================
     */

    /**
     * Display a listing of events for admin.
     */
    public function adminIndex()
    {
        $events = Event::latest()
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        // Get existing speakers for autocomplete
        $allSpeakers = Event::whereNotNull('speakers')
            ->pluck('speakers')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return view('admin.events.create', compact('allSpeakers'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'speakers' => 'nullable|string',
            'agenda' => 'nullable|string',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        // Process speakers (comma-separated string to array)
        if ($request->filled('speakers')) {
            $speakersArray = array_filter(
                array_map('trim', explode(',', $validated['speakers']))
            );
            $validated['speakers'] = json_encode($speakersArray);
        } else {
            $validated['speakers'] = null;
        }

        // Process agenda (JSON string validation)
        if ($request->filled('agenda')) {
            $agendaData = json_decode($validated['agenda'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                // Validate agenda items structure
                $validAgenda = [];
                foreach ($agendaData as $item) {
                    if (isset($item['time']) && isset($item['activity']) && 
                        !empty(trim($item['time'])) && !empty(trim($item['activity']))) {
                        $validAgenda[] = [
                            'time' => trim($item['time']),
                            'activity' => trim($item['activity'])
                        ];
                    }
                }
                $validated['agenda'] = !empty($validAgenda) ? json_encode($validAgenda) : null;
            } else {
                $validated['agenda'] = null;
            }
        } else {
            $validated['agenda'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        // Generate unique slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        
        // Set user_id (current admin)
        $validated['user_id'] = auth()->id();

        // Set default views
        $validated['views'] = 0;

        // Create event
        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        // Parse speakers for display
        if ($event->speakers && is_string($event->speakers)) {
            $speakersArray = json_decode($event->speakers, true);
            $event->speakers_display = $speakersArray ? implode(', ', $speakersArray) : '';
        } else {
            $event->speakers_display = '';
        }
        
        // Parse agenda for display
        if ($event->agenda && is_string($event->agenda)) {
            $event->agenda_list = json_decode($event->agenda, true);
        } else {
            $event->agenda_list = [];
        }
        
        // Get existing speakers for autocomplete
        $allSpeakers = Event::whereNotNull('speakers')
            ->where('id', '!=', $event->id)
            ->pluck('speakers')
            ->flatten()
            ->unique()
            ->filter()
            ->values();

        return view('admin.events.edit', compact('event', 'allSpeakers'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'speakers' => 'nullable|string',
            'agenda' => 'nullable|string',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        // Process speakers
        if ($request->filled('speakers')) {
            $speakersArray = array_filter(
                array_map('trim', explode(',', $validated['speakers']))
            );
            $validated['speakers'] = !empty($speakersArray) ? json_encode($speakersArray) : null;
        } else {
            $validated['speakers'] = null;
        }

        // Process agenda
        if ($request->filled('agenda')) {
            $agendaData = json_decode($validated['agenda'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validAgenda = [];
                foreach ($agendaData as $item) {
                    if (isset($item['time']) && isset($item['activity']) && 
                        !empty(trim($item['time'])) && !empty(trim($item['activity']))) {
                        $validAgenda[] = [
                            'time' => trim($item['time']),
                            'activity' => trim($item['activity'])
                        ];
                    }
                }
                $validated['agenda'] = !empty($validAgenda) ? json_encode($validAgenda) : null;
            } else {
                $validated['agenda'] = null;
            }
        } else {
            $validated['agenda'] = null;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        } elseif ($request->has('remove_image')) {
            // Remove image if checkbox is checked
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = null;
        } else {
            // Keep existing image if not updating
            unset($validated['image']);
        }

        // Update slug if title changed
        if ($event->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Toggle event status.
     */
    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);
        
        $newStatus = $event->status === 'published' ? 'draft' : 'published';
        $event->status = $newStatus;
        $event->save();

        return back()->with('success', "Event {$newStatus} successfully!");
    }

    /**
     * Display past events for public.
     */
    public function pastEvents()
    {
        $events = Event::where('status', 'published')
            ->where(function($query) {
                $query->where('date', '<', now()->toDateString())
                      ->orWhere(function($q) {
                          $q->whereDate('date', now()->toDateString())
                            ->where('time', '<', now()->format('H:i:s'));
                      });
            })
            ->orderBy('date', 'desc')
            ->orderByRaw('ISNULL(time), time desc')
            ->paginate(9);

        return view('events.past', compact('events'));
    }
}
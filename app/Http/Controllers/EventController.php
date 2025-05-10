<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Show list of events (only for the logged-in user)
    public function index()
    {
        $events = Auth::user()->role === 'admin'
            ? Event::latest()->get()
            : Auth::user()->events()->latest()->get();

        return view('events.index', compact('events'));
    }

    // Show form to create a new event
    public function create()
    {
        return view('events.create');
    }

    // Save new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event created.');
    }

    // Show form to edit an event
    public function edit(Event $event)
    {
        $this->authorizeEvent($event);
        return view('events.edit', compact('event'));
    }

    // Update an event
    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
        ]);

        $event->update($request->only('title', 'description', 'event_date'));

        return redirect()->route('events.index')->with('success', 'Event updated.');
    }

    // Delete an event
    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }

    // Protect user-specific events
    private function authorizeEvent(Event $event)
    {
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

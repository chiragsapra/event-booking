<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'country'     => 'required|string|max:255',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'capacity'    => 'required|integer|min:1'
        ], [
            'name.required'       => 'The event name is required.',
            'country.required'    => 'Please specify the country.',
            'start_time.required' => 'Start time is required.',
            'end_time.required'   => 'End time is required.',
            'end_time.after'      => 'End time must be after the start time.',
            'capacity.required'   => 'Please set a capacity.',
            'capacity.min'        => 'Capacity must be at least 1.',
        ]);

        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event created successfully.',
            'event'   => $event
        ], 201);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'country'     => 'sometimes|required|string|max:255',
            'start_time'  => 'sometimes|required|date',
            'end_time'    => 'sometimes|required|date|after:start_time',
            'capacity'    => 'sometimes|required|integer|min:1',
        ], [
            'end_time.after'    => 'End time must be after the start time.',
            'capacity.min'      => 'Capacity must be at least 1.',
        ]);


        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully.',
            'event'   => $event
        ]);
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully.'
        ]);
    }
}

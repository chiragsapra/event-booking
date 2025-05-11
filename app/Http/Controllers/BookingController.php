<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;

class BookingController extends Controller
{
    /**
     * List all bookings.
     */
    public function index()
    {
        return response()->json(
            Booking::with(['event', 'attendee'])->get(),
            200
        );
    }

    /**
     * Create a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'    => 'required|exists:events,id',
            'attendee_id' => 'required|exists:attendees,id'
        ], [
            'event_id.required'    => 'Event ID is required.',
            'event_id.exists'      => 'The selected event does not exist.',
            'attendee_id.required' => 'Attendee ID is required.',
            'attendee_id.exists'   => 'The selected attendee does not exist.',
        ]);

        $event = Event::findOrFail($validated['event_id']);
        $attendeeId = $validated['attendee_id'];

        // Check for duplicate booking
        $alreadyBooked = Booking::where('event_id', $event->id)
            ->where('attendee_id', $attendeeId)
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'message' => 'Attendee has already booked this event.'
            ], 400);
        }

        // Check event capacity
        $currentBookings = $event->bookings()->count();
        if ($currentBookings >= $event->capacity) {
            return response()->json([
                'message' => 'Event is fully booked.'
            ], 400);
        }

        // Create the booking
        $booking = Booking::create([
            'event_id'    => $event->id,
            'attendee_id' => $attendeeId,
        ]);

        return response()->json([
            'message' => 'Booking successful.',
            'booking' => $booking
        ], 201);
    }
}

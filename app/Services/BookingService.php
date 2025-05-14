<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function book(Event $event, array $data): Booking
    {
        if ($event->bookings()->count() >= $event->capacity) {
            throw ValidationException::withMessages(['event' => 'Event is fully booked']);
        }

        if ($event->bookings()->where('attendee_id', $data['attendee_id'])->exists()) {
            throw ValidationException::withMessages(['attendee_id' => 'Attendee already booked for this event']);
        }

        return $event->bookings()->create($data);
    }
}

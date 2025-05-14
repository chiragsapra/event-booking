<?php
namespace App\Services;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function list(int $perPage = 10)
    {
        return Booking::with(['event', 'attendee'])->paginate($perPage);
    }

    public function create(Event $event, int $attendeeId): Booking
    {
        if ($event->bookings()->where('attendee_id', $attendeeId)->exists()) {
            throw ValidationException::withMessages([
                'attendee_id' => ['This attendee has already booked this event.'],
            ]);
        }

        if ($event->bookings()->count() >= $event->capacity) {
            throw ValidationException::withMessages([
                'event_id' => ['This event is fully booked.'],
            ]);
        }

        return Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendeeId,
        ]);
    }

    public function update(Booking $booking, array $data): Booking
    {
        $booking->update($data);
        return $booking;
    }

    public function delete(Booking $booking): void
    {
        $booking->delete();
    }
}

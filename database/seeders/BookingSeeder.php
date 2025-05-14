<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();
        $attendees = Attendee::all();

        foreach ($events as $event) {
            $booked = 0;
            foreach ($attendees->shuffle() as $attendee) {
                if ($booked >= $event->capacity) {
                    break;
                }

                // Avoid duplicate bookings
                if (!Booking::where('event_id', $event->id)->where('attendee_id', $attendee->id)->exists()) {
                    Booking::create([
                        'event_id' => $event->id,
                        'attendee_id' => $attendee->id,
                    ]);
                    $booked++;
                }
            }
        }
    }
}

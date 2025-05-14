<?php

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'attendee_id' => Attendee::factory(),
            'event_id' => Event::factory(),
        ];
    }
}

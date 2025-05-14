<?php

namespace Tests\Feature;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_book_event()
    {
        $event = Event::factory()->create(['capacity' => 2]);
        $attendee = Attendee::factory()->create();

        $response = $this->postJson("/api/events/{$event->id}/bookings", [
            'attendee_id' => $attendee->id
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.attendee_id', $attendee->id);
    }

    public function test_cannot_book_same_event_twice()
    {
        $event = Event::factory()->create(['capacity' => 5]);
        $attendee = Attendee::factory()->create();

        $this->postJson("/api/events/{$event->id}/bookings", ['attendee_id' => $attendee->id]);

        $response = $this->postJson("/api/events/{$event->id}/bookings", ['attendee_id' => $attendee->id]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['attendee_id']);
    }

    public function test_cannot_overbook_event()
    {
        $event = Event::factory()->create(['capacity' => 1]);
        $attendee1 = Attendee::factory()->create();
        $attendee2 = Attendee::factory()->create();

        $this->postJson("/api/events/{$event->id}/bookings", ['attendee_id' => $attendee1->id]);
        $response = $this->postJson("/api/events/{$event->id}/bookings", ['attendee_id' => $attendee2->id]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['event']);
    }
}

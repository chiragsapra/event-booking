<?php

namespace Tests\Unit;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookingService $bookingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookingService = new BookingService();
    }

    public function test_can_book_attendee_to_event()
    {
        $event = Event::factory()->create(['capacity' => 5]);
        $attendee = Attendee::factory()->create();

        $booking = $this->bookingService->book($event, $attendee->id);

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals($attendee->id, $booking->attendee_id);
    }

    public function test_throws_exception_when_event_is_full()
    {
        $this->expectException(ValidationException::class);

        $event = Event::factory()->create(['capacity' => 1]);
        $attendee1 = Attendee::factory()->create();
        $attendee2 = Attendee::factory()->create();

        $this->bookingService->book($event, $attendee1->id);
        $this->bookingService->book($event, $attendee2->id); // Should fail
    }

    public function test_throws_exception_when_already_booked()
    {
        $this->expectException(ValidationException::class);

        $event = Event::factory()->create(['capacity' => 5]);
        $attendee = Attendee::factory()->create();

        $this->bookingService->book($event, $attendee->id);
        $this->bookingService->book($event, $attendee->id); // Should fail
    }
}

<?php


namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Attendee;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookingService $bookingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookingService = app(BookingService::class);
    }

    public function test_create_booking()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();

        $booking = $this->bookingService->create($event->id, $attendee->id);

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals($event->id, $booking->event_id);
        $this->assertEquals($attendee->id, $booking->attendee_id);
    }

    public function test_prevent_duplicate_booking()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();

        $this->bookingService->create($event->id, $attendee->id);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Attendee already booked for this event.');

        $this->bookingService->create($event->id, $attendee->id);
    }

    public function test_prevent_overbooking()
    {
        $event = Event::factory()->create(['capacity' => 1]);
        Attendee::factory()->count(2)->create()->each(function ($attendee) use ($event) {
            $this->bookingService->create($event->id, $attendee->id);
        });

        $this->assertEquals(1, $event->bookings()->count());
    }
}

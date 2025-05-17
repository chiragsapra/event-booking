<?php
namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Attendee;
use App\Services\BookingService;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_booking()
    {
        $event = Event::factory()->create();
        $attendee = Attendee::factory()->create();
        $booking = Booking::factory()->make([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);

        $mock = Mockery::mock(BookingService::class);
        $this->app->instance(BookingService::class, $mock);

        $mock->shouldReceive('createBooking')->once()->andReturn($booking);

        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['event_id' => $event->id]);
    }

    public function test_index_returns_all_bookings()
    {
        $bookings = Booking::factory()->count(2)->make();

        $mock = Mockery::mock(BookingService::class);
        $this->app->instance(BookingService::class, $mock);

        $mock->shouldReceive('listBookings')->once()->andReturn($bookings);

        $response = $this->getJson('/api/bookings');

        $response->assertOk()
            ->assertJsonCount(2);
    }

    public function test_destroy_deletes_booking()
    {
        $booking = Booking::factory()->create();

        $mock = Mockery::mock(BookingService::class);
        $this->app->instance(BookingService::class, $mock);

        $mock->shouldReceive('deleteBooking')->once()->andReturn(true);

        $response = $this->deleteJson("/api/bookings/{$booking->id}");

        $response->assertNoContent();
    }
}

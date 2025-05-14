<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Event;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(): JsonResponse
    {
        $bookings = $this->bookingService->list();
        return response()->json(['data' => $bookings]);
    }

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $booking = $this->bookingService->create(
            Event::findOrFail($request->event_id),
            $request->attendee_id
        );

        return response()->json(['data' => $booking], 201);
    }

    public function update(StoreBookingRequest $request, Booking $booking): JsonResponse
    {
        $updated = $this->bookingService->update($booking, $request->validated());
        return response()->json(['data' => $updated]);
    }

    public function destroy(Booking $booking): JsonResponse
    {
        $this->bookingService->delete($booking);
        return response()->json(['message' => 'Booking cancelled']);
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Event;
use App\Services\BookingService;
use App\Traits\ApiResponse;

class BookingController extends Controller
{
    use ApiResponse;

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function book(StoreBookingRequest $request, Event $event)
    {
        $booking = $this->bookingService->book($event, $request->validated());
        return $this->success($booking, 'Booking successful', 201);
    }
}

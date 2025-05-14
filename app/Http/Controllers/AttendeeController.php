<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Services\AttendeeService;
use App\Traits\ApiResponse;

class AttendeeController extends Controller
{
    use ApiResponse;

    protected $attendeeService;

    public function __construct(AttendeeService $attendeeService)
    {
        $this->attendeeService = $attendeeService;
    }

    public function store(StoreAttendeeRequest $request)
    {
        $attendee = $this->attendeeService->register($request->validated());
        return $this->success($attendee, 'Attendee registered successfully', 201);
    }
}

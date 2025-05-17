<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\UpdateAttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Traits\ApiResponse;
use App\Services\AttendeeService;
use Illuminate\Http\JsonResponse;

class AttendeeController extends Controller
{
    use ApiResponse;

    protected AttendeeService $attendeeService;

    public function __construct(AttendeeService $attendeeService)
    {
        $this->attendeeService = $attendeeService;
    }

    public function index(): JsonResponse
    {
        $attendees = $this->attendeeService->list();
        return response()->json(['data' => AttendeeResource::collection($attendees)]);
    }


    public function show(Attendee $Attendee)
    {
        return response()->json(['data' => new AttendeeResource($Attendee)]);
    }

    public function store(StoreAttendeeRequest $request): JsonResponse
    {
        $attendee = $this->attendeeService->create($request->validated());
        return response()->json(['data' => new AttendeeResource($attendee)], 201);
    }

    public function update(UpdateAttendeeRequest $request, $id): JsonResponse
    {
        $attendee = $this->attendeeService->update($id, $request->validated());
        return response()->json(['data' => new AttendeeResource($attendee)]);
    }

    public function destroy(Attendee $attendee): JsonResponse
    {
        $this->attendeeService->delete($attendee);
        return response()->json(['message' => 'Attendee deleted successfully']);
    }
}

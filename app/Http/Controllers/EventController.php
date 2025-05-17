<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use App\Traits\ApiResponse;

class EventController extends Controller
{
    use ApiResponse;

    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->list(request()->all(), request('per_page', 10));
        return response()->json(['data' => EventResource::collection($events)]);
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->create($request->validated());
        return response()->json(['data' => new EventResource($event)], 201);
    }

    public function show(Event $event)
    {
        return response()->json(['data' => new EventResource($event)]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event = $this->eventService->update($event, $request->validated());
        return response()->json(['data' => new EventResource($event)]);
    }

    public function destroy(Event $event)
    {
        $this->eventService->delete($event);
        return $this->success(null, 'Event deleted successfully');
    }
}

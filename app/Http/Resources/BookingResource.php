<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'event' => new EventResource($this->whenLoaded('event')),
            'attendee' => new AttendeeResource($this->whenLoaded('attendee')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

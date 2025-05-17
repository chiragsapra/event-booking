<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'country' => $this->country,
            'capacity' => $this->capacity,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

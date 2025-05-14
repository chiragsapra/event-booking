<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): void
    {
        $event->delete();
    }

    public function list(array $filters = [], int $perPage = 10)
    {
        return Event::query()
            ->when($filters['country'] ?? null, fn($q, $v) => $q->where('country', $v))
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where('name', 'like', "%$v%"))
            ->paginate($perPage);
    }
}

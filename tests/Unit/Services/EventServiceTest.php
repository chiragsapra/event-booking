<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventService $eventService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventService = app(EventService::class);
    }

    public function test_create_event()
    {
        $data = [
            'title' => 'Laravel Conf',
            'description' => 'A Laravel conference.',
            'date' => now()->addWeek()->toDateString(),
            'country' => 'USA',
            'capacity' => 100,
        ];

        $event = $this->eventService->create($data);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('Laravel Conf', $event->title);
    }

    public function test_update_event()
    {
        $event = Event::factory()->create();

        $updated = $this->eventService->update($event->id, [
            'title' => 'Updated Event',
        ]);

        $this->assertEquals('Updated Event', $updated->title);
    }

    public function test_delete_event()
    {
        $event = Event::factory()->create();

        $result = $this->eventService->delete($event->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventService $eventService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventService = new EventService();
    }

    public function test_create_event()
    {
        $data = Event::factory()->make()->toArray();
        $event = $this->eventService->create($data);
        $this->assertDatabaseHas('events', ['name' => $data['name']]);
        $this->assertEquals($data['name'], $event->name);
    }

    public function test_update_event()
    {
        $event = Event::factory()->create();
        $updated = $this->eventService->update($event, ['name' => 'Updated Name']);
        $this->assertEquals('Updated Name', $updated->name);
    }

    public function test_delete_event()
    {
        $event = Event::factory()->create();
        $this->eventService->delete($event);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}

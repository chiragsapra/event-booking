<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event()
    {
        $event = Event::factory()->make()->toArray();
        $response = $this->postJson('/api/events', $event);
        $response->assertCreated()
            ->assertJsonPath('data.name', $event['name']);
    }

    public function test_cannot_create_event_with_invalid_data()
    {
        $response = $this->postJson('/api/events', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'country', 'start_time', 'end_time', 'capacity']);
    }

    public function test_can_list_events_with_pagination_and_filtering()
    {
        Event::factory()->count(5)->create(['country' => 'USA']);
        Event::factory()->count(5)->create(['country' => 'Canada']);

        $response = $this->getJson('/api/events?country=USA&per_page=3');

        $response->assertOk()
            ->assertJsonCount(3, 'data.data')
            ->assertJsonPath('data.data.0.country', 'USA');
    }

    public function test_can_update_event()
    {
        $event = Event::factory()->create();

        $response = $this->putJson("/api/events/{$event->id}", [
            'name' => 'Updated Event Name',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.name', 'Updated Event Name');
    }

    public function test_can_delete_event()
    {
        $event = Event::factory()->create();
        $response = $this->deleteJson("/api/events/{$event->id}");
        $response->assertNoContent();
    }
}

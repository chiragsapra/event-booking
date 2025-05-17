<?php
namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Event;
use App\Services\EventService;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_events()
    {
        $mock = Mockery::mock(EventService::class);
        $this->app->instance(EventService::class, $mock);

        $events = Event::factory()->count(2)->make();
        $mock->shouldReceive('listEvents')->once()->andReturn($events);

        $response = $this->getJson('/api/events');

        $response->assertOk()
            ->assertJsonFragment(['title' => $events[0]->title]);
    }

    public function test_store_creates_event()
    {
        $mock = Mockery::mock(EventService::class);
        $this->app->instance(EventService::class, $mock);

        $event = Event::factory()->make();

        $mock->shouldReceive('createEvent')->once()->andReturn($event);

        $response = $this->postJson('/api/events', $event->toArray());

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => $event->title]);
    }

    public function test_update_modifies_event()
    {
        $event = Event::factory()->create();
        $mock = Mockery::mock(EventService::class);
        $this->app->instance(EventService::class, $mock);

        $mock->shouldReceive('updateEvent')->once()->andReturn($event);

        $response = $this->putJson("/api/events/{$event->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_destroy_deletes_event()
    {
        $event = Event::factory()->create();
        $mock = Mockery::mock(EventService::class);
        $this->app->instance(EventService::class, $mock);

        $mock->shouldReceive('deleteEvent')->once()->andReturn(true);

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertNoContent();
    }
}


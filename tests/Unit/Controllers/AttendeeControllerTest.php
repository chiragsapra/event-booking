<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Attendee;
use App\Services\AttendeeService;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendeeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_store_attendee_returns_success()
    {
        $mock = Mockery::mock(AttendeeService::class);
        $this->app->instance(AttendeeService::class, $mock);

        $attendee = Attendee::factory()->make();

        $mock->shouldReceive('createAttendee')
            ->once()
            ->andReturn($attendee);

        $response = $this->postJson('/api/attendees', [
            'name' => $attendee->name,
            'email' => $attendee->email
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => $attendee->name]);
    }
}

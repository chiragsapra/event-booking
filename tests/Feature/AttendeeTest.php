<?php

namespace Tests\Feature;

use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_register_attendee()
    {
        $attendee = Attendee::factory()->make()->toArray();
        $response = $this->postJson('/api/attendees', $attendee);
        $response->assertCreated()
            ->assertJsonPath('data.email', $attendee['email']);
    }

    public function test_attendee_registration_validation()
    {
        $response = $this->postJson('/api/attendees', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email']);
    }
}


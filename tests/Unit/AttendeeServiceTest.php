<?php

namespace Tests\Unit;

use App\Models\Attendee;
use App\Services\AttendeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendeeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AttendeeService $attendeeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attendeeService = new AttendeeService();
    }

    public function test_register_attendee()
    {
        $data = Attendee::factory()->make()->toArray();
        $attendee = $this->attendeeService->register($data);
        $this->assertDatabaseHas('attendees', ['email' => $data['email']]);
        $this->assertEquals($data['email'], $attendee->email);
    }
}


<?php


namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Attendee;
use App\Services\AttendeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendeeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AttendeeService $attendeeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attendeeService = app(AttendeeService::class);
    }

    public function test_create_attendee()
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $attendee = $this->attendeeService->create($data);

        $this->assertInstanceOf(Attendee::class, $attendee);
        $this->assertEquals('Jane Doe', $attendee->name);
    }

    public function test_update_attendee()
    {
        $attendee = Attendee::factory()->create();

        $updated = $this->attendeeService->update($attendee->id, [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertEquals('Updated Name', $updated->name);
        $this->assertEquals('updated@example.com', $updated->email);
    }

    public function test_delete_attendee()
    {
        $attendee = Attendee::factory()->create();

        $result = $this->attendeeService->delete($attendee->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('attendees', ['id' => $attendee->id]);
    }
}

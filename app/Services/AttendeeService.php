<?php
namespace App\Services;

use App\Models\Attendee;

class AttendeeService
{
    public function list(int $perPage = 10)
    {
        return Attendee::paginate($perPage);
    }

    public function create(array $data): Attendee
    {
        return Attendee::create($data);
    }

    public function update(Attendee $attendee, array $data): Attendee
    {
        $attendee->update($data);
        return $attendee;
    }

    public function delete(Attendee $attendee): void
    {
        $attendee->delete();
    }
}


<?php

namespace App\Services;

use App\Models\Attendee;

class AttendeeService
{
    public function register(array $data): Attendee
    {
        return Attendee::create($data);
    }
}

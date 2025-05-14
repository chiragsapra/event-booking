<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attendee_id' => 'required|exists:attendees,id',
        ];
    }
}

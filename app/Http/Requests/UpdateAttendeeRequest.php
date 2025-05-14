<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust if using policies/auth
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:attendees,email,' . $this->route('attendee')->id],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Attendee name is required.',
            'email.required' => 'Attendee email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
        ];
    }
}


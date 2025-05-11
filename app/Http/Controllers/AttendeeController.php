<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;

class AttendeeController extends Controller
{
    /**
     * List all attendees.
     */
    public function index()
    {
        return response()->json(Attendee::all(), 200);
    }

    /**
     * Register a new attendee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email'
        ], [
            'name.required'  => 'Attendee name is required.',
            'email.required' => 'Email address is required.',
            'email.email'    => 'Email must be valid.',
            'email.unique'   => 'This email is already registered.',
        ]);

        $attendee = Attendee::create($validated);

        return response()->json([
            'message'  => 'Attendee registered successfully.',
            'attendee' => $attendee
        ], 201);
    }

    /**
     * Show a specific attendee.
     */
    public function show(Attendee $attendee)
    {
        return response()->json($attendee, 200);
    }

    /**
     * Update attendee info.
     */
    public function update(Request $request, Attendee $attendee)
    {
        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:attendees,email,' . $attendee->id
        ]);

        $attendee->update($validated);

        return response()->json([
            'message'  => 'Attendee updated successfully.',
            'attendee' => $attendee
        ], 200);
    }

    /**
     * Delete an attendee.
     */
    public function destroy(Attendee $attendee)
    {
        $attendee->delete();

        return response()->json([
            'message' => 'Attendee deleted successfully.'
        ], 200);
    }
}

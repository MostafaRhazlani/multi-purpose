<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusType;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index() {

        return Appointment::query()
            ->with('client:id,first_name,last_name')
            ->when(request('status'), function ($query) {
                return $query->where('status', StatusType::from(request('status')));
            })
            ->latest()
            ->paginate(setting('pagination_limit'))
            ->through(fn ($appointment) => [
                'id' => $appointment->id,
                'start_time' => $appointment->start_time->format(setting('date_format')),
                'end_time' => $appointment->end_time->format('h:i A'),
                'status' => [
                    'name' => $appointment->status->name,
                    'color' => $appointment->status->color(),
                ],
                'client' => $appointment->client,
            ]);
    }

    public function store() {

        $validated = request()->validate([
            'client_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ],
        [
            'client_id.required' => 'The client name field is required.',
        ]);

        Appointment::create([
            'title' => $validated['title'],
            'client_id' => $validated['client_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'description' => $validated['description'],
            'status' => StatusType::SCHEDULED,
        ]);
        return response()->json(['message' => 'success']);
    }

    public function edit(Appointment $appointment) {
        return $appointment;
    }

    public function update(Appointment $appointment) {

        $validated = request()->validate([
            'client_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ],
        [
            'client_id.required' => 'The client name field is required.',
        ]);

        $appointment->update([
            'title' => $validated['title'],
            'client_id' => $validated['client_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'description' => $validated['description'],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Appointment $appointment) {

        $appointment->delete();

        return response()->json(['success' => true], 200);
    }
}

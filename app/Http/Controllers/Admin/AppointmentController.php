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
            ->paginate()
            ->through(fn ($appointment) => [
                'id' => $appointment->id,
                'start_time' => $appointment->start_time->format('Y-m-d'),
                'end_time' => $appointment->end_time->format('h:i A'),
                'status' => [
                    'name' => $appointment->status->name,
                    'color' => $appointment->status->color(),
                ],
                'client' => $appointment->client,
            ]);
    }
}

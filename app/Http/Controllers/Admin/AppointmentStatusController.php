<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusType;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentStatusController extends Controller
{
    public function getCountStatus() {

        $cases = StatusType::cases();

        return collect($cases)->map(function ($status) {
            return [
                'name' => $status->name,
                'value' => $status->value,
                'count' => Appointment::where('status', $status->value)->count(),
                'color' => StatusType::from($status->value)->color()
            ];
        });
    }
}

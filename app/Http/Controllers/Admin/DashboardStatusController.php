<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\StatusType;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardStatusController extends Controller
{
    public function getAppointments() {

        $totalAppointmentCount = Appointment::query()
        ->when(request('status') === 'scheduled', function ($query) {
            $query->where('status', StatusType::SCHEDULED);
        })
        ->when(request('status') === 'confirmed', function ($query) {
            $query->where('status', StatusType::CONFIRMED);
        })
        ->when(request('status') === 'cancelled', function ($query) {
            $query->where('status', StatusType::CANCELLED);
        })
        ->count();

        return response()->json(['totalAppointmentCount' => $totalAppointmentCount]);
    }

    public function getUsers() {

        $totalUsersCount = User::query()
        ->when(request('dateRange') === 'today', function($query) {
            $query->whereBetween('created_at', [now()->today(), now()]);
        })
        ->when(request('dateRange') === '30_days', function($query) {
            $query->whereBetween('created_at', [now()->subDays(30), now()]);
        })
        ->when(request('dateRange') === '60_days', function($query) {
            $query->whereBetween('created_at', [now()->subDays(60), now()]);
        })
        ->when(request('dateRange') === '360_days', function($query) {
            $query->whereBetween('created_at', [now()->subDays(360), now()]);
        })
        ->when(request('dateRange') === 'month_to_date', function($query) {
            $query->whereBetween('created_at', [now()->firstOfMonth(), now()]);
        })
        ->when(request('dateRange') === 'year_to_date', function($query) {
            $query->whereBetween('created_at', [now()->firstOfYear(), now()]);
        })
        ->count();


        return response()->json(['totalUsersCount' => $totalUsersCount]);
    }
}

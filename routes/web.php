<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardStatusController;
use App\Http\Controllers\Admin\AppointmentStatusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    // dashboard routs
    Route::get('/api/status/appointments', [DashboardStatusController::class, 'getAppointments']);
    Route::get('/api/users/status', [DashboardStatusController::class, 'getUsers']);
    // end dashboard routs

    // route users
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
    Route::put('/api/users/{user}', [UserController::class, 'update']);
    Route::delete('/api/users/{user}', [UserController::class, 'destroy']);

    Route::patch('/api/users/{user}/change-role', [UserController::class, 'changeRole']);

    Route::delete('/api/users', [UserController::class, 'bulkDelete']);
    // end route users

    // route appointments
    Route::get('/api/appointments/', [AppointmentController::class, 'index']);
    Route::post('/api/appointments/create', [AppointmentController::class, 'store']);
    Route::get('/api/appointment/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::put('/api/appointments/{appointment}/edit', [AppointmentController::class, 'update']);
    Route::delete('/api/appointments/{appointment}', [AppointmentController::class, 'destroy']);
    Route::get('/api/appointment-status', [AppointmentStatusController::class, 'getCountStatus']);
    // end route appointments

    // route clients
    Route::get('/api/clients', [ClientController::class, 'index']);
    // end route clients

    // settings route
    Route::get('/api/settings', [SettingController::class, 'index']);
    Route::post('/api/settings', [SettingController::class, 'update']);
    // end settings route

    // profile route
    Route::get('/api/profile', [ProfileController::class, 'index']);
    Route::put('/api/profile', [ProfileController::class, 'update']);
    Route::post('/api/upload-profile-image', [ProfileController::class, 'uploadImage']);
    Route::post('/api/change-user-password', [ProfileController::class, 'changePassword']);
    // end profile route
});

Route::get('{view}', ApplicationController::class)->where('view', '(.*)')->middleware('auth');

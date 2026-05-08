<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DoctorController;

Route::get('/', function (){
    return view ('admin.dashboard');
})->name( 'dashboard');

//Gestión de roles
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

//Gestión de pacientes
Route::resource('patients', PatientController::class);

// Gestión de doctores
Route::resource('doctors', DoctorController::class);
Route::get('doctors/{doctor}/schedules', [DoctorController::class, 'schedules'])->name('doctors.schedules');

// Gestión de citas
Route::resource('appointments', AppointmentController::class);
Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])->name('appointments.consultation');

// Calendario
Route::get('calendar', function () {
    $events = App\Models\Appointment::with('patient.user')->get()->map(function($app) {
        $startTime = $app->start_time ? \Carbon\Carbon::parse($app->start_time)->format('H:i') : '';
        return [
            'title' => $startTime . ' ' . ($app->patient->name ?? 'Paciente'),
            'start' => $app->date . ($app->start_time ? 'T' . $app->start_time : ''),
            'end' => $app->date . ($app->end_time ? 'T' . $app->end_time : ''),
            'backgroundColor' => '#3b82f6', // blue-500
            'borderColor' => '#3b82f6',
        ];
    });
    return view('admin.calendar.index', ['events' => $events]);
})->name('calendar.index');
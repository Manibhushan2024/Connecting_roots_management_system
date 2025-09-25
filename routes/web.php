<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public appointment booking (for new patients)
Route::get('/book-appointment', [AppointmentController::class, 'createPublic'])->name('appointments.create.public');
Route::post('/book-appointment', [AppointmentController::class, 'storePublic'])->name('appointments.store.public');

// Admin appointment management (for existing patients) - REPLACES your individual appointment routes
Route::resource('appointments', AppointmentController::class);

// Patient Routes
Route::resource('patients', PatientController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
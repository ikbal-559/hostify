<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use Inertia\Inertia;

Route::get('/', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservation/{reservation}', [ReservationController::class, 'book'])->name('reservation.book');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservations.store');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('room-types', RoomTypeController::class);
    Route::resource('rooms', RoomController::class);
    // Allow POST for update to support file uploads with method override
    Route::post('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    


});

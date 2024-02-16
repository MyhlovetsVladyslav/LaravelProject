<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TrainCarriageController;
use App\Http\Controllers\TrainSeatController;
use App\Http\Controllers\BusSeatController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TripController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web route for your application. These
| route are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::get('/events/searchRoutes', [EventController::class, 'searchRoutes'])->name('events.searchRoutes');
        Route::get('/events/searchTransports', [EventController::class, 'searchTransports'])->name('events.searchTransports');
        Route::get('/events/searchTrip', [EventController::class, 'searchTrip'])->name('events.searchTrip');
        Route::get('/events/searchUser', [EventController::class, 'searchUser'])->name('events.searchUser');
        Route::resource('/users', UserController::class)->names('users');
        Route::resource('/transports', TransportController::class)->names('transports');
        Route::resource('/routes', RouteController::class)->names('routes');
        Route::resource('/trips', TripController::class)->names('trips');
        Route::resource('/tickets', TicketController::class)->names('tickets');
        Route::prefix('transports')->name('transports.')->group(function () {
            //CRUD CARRIAGE
            Route::get('train/{train_id}', [TrainCarriageController::class, 'index'])->name('train.index');
            Route::get('train/{train_id}/create', [TrainCarriageController::class, 'create'])->name('train.create');
            Route::post('train/{train_id}', [TrainCarriageController::class, 'store'])->name('train.store');
            Route::get('train/{train_id}/carriage/{carriage}/edit', [TrainCarriageController::class, 'edit'])->name('train.edit');
            Route::put('train/{train_id}/carriage/{carriage}', [TrainCarriageController::class, 'update'])->name('train.update');
            Route::delete('train/{train_id}/carriage/{carriage}', [TrainCarriageController::class, 'destroy'])->name('train.destroy');
            //CRUD SEAT FOR CARRIAGE
            Route::get('train/{train_id}/carriage/{carriage_id}', [TrainSeatController::class, 'index'])->name('carriage.index');
            Route::get('train/{train_id}/carriage/{carriage_id}/create', [TrainSeatController::class, 'create'])->name('carriage.create');
            Route::post('train/{train_id}/carriage/{carriage_id}', [TrainSeatController::class, 'store'])->name('carriage.store');
            Route::get('train/{train_id}/carriage/{carriage_id}/seat/{seat}/edit', [TrainSeatController::class, 'edit'])->name('carriage.edit');
            Route::put('train/{train_id}/carriage/{carriage_id}/seat/{seat}', [TrainSeatController::class, 'update'])->name('carriage.update');
            Route::delete('train/{train_id}/carriage/{carriage_id}/seat/{seat}', [TrainSeatController::class, 'destroy'])->name('carriage.destroy');
            //CRUD SEAT FOR BUS
            Route::get('bus/{bus_id}', [BusSeatController::class, 'index'])->name('bus.index');
            Route::get('bus/{bus_id}/create', [BusSeatController::class, 'create'])->name('bus.create');
            Route::post('bus/{bus_id}', [BusSeatController::class, 'store'])->name('bus.store');
            Route::get('bus/{bus_id}/seat/{seat}/edit', [BusSeatController::class, 'edit'])->name('bus.edit');
            Route::put('bus/{bus_id}/seat/{seat}', [BusSeatController::class, 'update'])->name('bus.update');
            Route::delete('bus/{bus_id}/seat/{seat}', [BusSeatController::class, 'destroy'])->name('bus.destroy');
            //CRUD SEAT FOR PLANE
            /*Route::get('plane/{plane_id}', [BusSeatController::class, 'index'])->name('bus.index');
            Route::get('plane/{plane_id}/create', [BusSeatController::class, 'create'])->name('bus.create');
            Route::post('plane/{plane_id}', [BusSeatController::class, 'store'])->name('bus.store');*/
        });
    });
});

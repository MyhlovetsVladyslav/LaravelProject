<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TrainCarriageController;
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
    return "Welcome";
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('/users', UserController::class)->names('users');
    Route::resource('/transports', TransportController::class)->names('transports');
    Route::prefix('transports')->name('transports.')->group(function () {
        Route::resource('/train/{train_id}/{train_type}', TrainCarriageController::class)->names('train');
        Route::resource('/train/{train_id}', TrainCarriageController::class)->names('carriage');
    });

});

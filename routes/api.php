<?php

use App\Http\Controllers\CancelSpotReservationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1/trips")->name("trips.")->group(function () {
    Route::post('create', [TripController::class, 'create'])->name("create");
    Route::get('list/{id}', [TripController::class, 'list'])->name("list");
});

Route::prefix("v1/trip/reservation")->name("trip_reservation.")->group(function () {
    Route::post('create', [TripReservationController::class, 'create'])->name("create");
});

Route::prefix("v1/trip/reservation/cancellation")->name("trip_reservation_cancellation.")->group(function () {
    Route::post('cancelSpotReservation', [CancelSpotReservationController::class, 'cancelSpotReservation'])->name("cancel");
});

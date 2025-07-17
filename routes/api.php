<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientBookingController;
use App\Http\Controllers\Api\TalentBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:talent'])->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
  Route::post('/services', [ServiceController::class, 'store']);
  Route::patch('/services/{service}', [ServiceController::class, 'update']);
  Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

  // Route untuk melihat booking yang masuk dari client
  Route::get('/talent/bookings', [TalentBookingController::class, 'index']);

  // Route untuk menerima booking
  Route::patch('/talent/bookings/{booking}/reject', [TalentBookingController::class, 'accept']);

  // Route untuk menolak booking
  Route::patch('/talent/bookings/{booking}/reject', [TalentBookingController::class, 'reject']);
});

Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
  Route::get('/client/bookings', [ClientBookingController::class, 'index']);
  Route::post('/bookings', [BookingController::class, 'store']);
});


Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

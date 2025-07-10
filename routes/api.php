<?php

use App\Http\Controllers\Api\AuthController;
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
});


Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

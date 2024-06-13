<?php

declare(strict_types=1);

use App\Http\Controllers\ListBookingsController;
use App\Http\Controllers\ShowCustomerController;
use App\Http\Controllers\ListRoomsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StoreBookingController;
use App\Http\Controllers\StoreCustomerController;
use App\Http\Controllers\ShowRoomController;
use App\Http\Controllers\StorePaymentController;
use App\Http\Controllers\StoreRoomController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:public-api'])->group(function () {
    Route::get('/list-bookings', ListBookingsController::class);
    Route::get('/list-rooms', ListRoomsController::class);
    Route::get('/show-customer/{id}', ShowCustomerController::class);
    Route::get('/show-room/{id}', ShowRoomController::class);
});

Route::middleware(['throttle:auth-api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', LoginController::class);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/store-customer', StoreCustomerController::class);
        Route::post('/store-room', StoreRoomController::class);
        Route::post('/store-booking', StoreBookingController::class);
        Route::post('/store-payment', StorePaymentController::class);
    });
});


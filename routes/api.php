<?php

use App\Http\Controllers\Api\TrackingController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')
    ->group(function () {
        Route::post('trackShipment', [TrackingController::class, 'trackShipment'])
            ->name('trackShipment');
    })->middleware(Authenticate::using('sanctum'));

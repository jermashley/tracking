<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\ImageTypesController;
use App\Http\Controllers\Api\ThemeController;
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

        Route::patch('companies/{company}/toggleMapOption', [CompanyController::class, 'toggleMapOption'])->name('companies.toggleMapOption');
        Route::patch('companies/{company}/toggleActive', [CompanyController::class, 'toggleActive'])->name('companies.toggleActive');
        Route::patch('companies/{company}/setTheme', [CompanyController::class, 'setTheme'])->name('companies.setTheme');
        Route::patch('companies/{company}/setImageAsset', [CompanyController::class, 'setImageAsset'])->name('companies.setImageAsset');
        Route::apiResource('companies', CompanyController::class);

        Route::apiResource('imageTypes', ImageTypesController::class);

        Route::apiResource('images', ImagesController::class);

        Route::apiResource('themes', ThemeController::class);
    })->middleware(Authenticate::using('sanctum'));

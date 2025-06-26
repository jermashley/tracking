<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\ImageTypesController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\EnsureUserCanImpersonate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('shipmentTracking', [TrackingController::class, 'trackingStatuses'])->name('shipmentTracking');
        Route::post('shipmentCoordinates', [TrackingController::class, 'shipmentCoordinates'])->name('shipmentCoordinates');

        Route::patch('companies/{company}/toggleMapOption', [CompanyController::class, 'toggleMapOption'])->name('companies.toggleMapOption');
        Route::patch('companies/{company}/toggleActive', [CompanyController::class, 'toggleActive'])->name('companies.toggleActive');
        Route::patch('companies/{company}/setTheme', [CompanyController::class, 'setTheme'])->name('companies.setTheme');
        Route::patch('companies/{company}/setImageAsset', [CompanyController::class, 'setImageAsset'])->name('companies.setImageAsset');
        Route::apiResource('companies', CompanyController::class);

        Route::apiResource('imageTypes', ImageTypesController::class);

        Route::apiResource('images', ImagesController::class);

        Route::apiResource('themes', ThemeController::class);

        Route::post('/impersonate/stop', [ImpersonationController::class, 'stopImpersonate'])
            ->withoutMiddleware(EnsureUserCanImpersonate::class)
            ->name('impersonate.stop');

        Route::as('admin.')
            ->group(function () {
                Route::put('roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])
                    ->name('roles.assignPermissions');

                Route::apiResource('roles', RoleController::class);

                Route::patch('users/{user}/role', [UserController::class, 'updateRole'])
                    ->middleware(EnsureSuperAdmin::class)
                    ->name('users.update.role');

                Route::apiResource('users', UserController::class);

                Route::post('/impersonate/{userId}', [ImpersonationController::class, 'impersonate'])
                    ->middleware(EnsureUserCanImpersonate::class)
                    ->name('impersonate.start');

                Route::apiResource('permissions', PermissionController::class)
                    ->middleware(EnsureSuperAdmin::class);
            });
    });

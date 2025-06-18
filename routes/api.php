<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\ImageTypesController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')
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

        Route::apiResource('roles', RoleController::class);

        Route::get('admin/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('admin/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('admin/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('admin/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update.role');

        Route::put('roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assignPermissions');
    })->middleware(Authenticate::using('sanctum'));

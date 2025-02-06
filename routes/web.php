<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\DetailedTrackingController;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('admin.dashboard'));
    }

    return redirect(route('login'));
})->name('home');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect(route('admin.dashboard'));
    }

    return Inertia::render('auth/Login');
})->name('login');

Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('admin/Dashboard');
        })->name('dashboard');

        Route::get('/company/create', function () {
            return Inertia::render('admin/company/Create');
        })->name('company.create');

        Route::get('/company/{company:uuid}', function (Company $company) {
            $company->load(['logo', 'banner', 'footer', 'theme']);

            return Inertia::render('admin/company/Edit', [
                'companyInitialValues' => $company,
            ]);
        })->name('company.show');
    });

Route::get('/trackShipment', [DetailedTrackingController::class, 'index'])->name('trackShipment.index');
Route::get('/trackShipment/notFound/{trackingNumber}', [DetailedTrackingController::class, 'trackingDataNotFound'])->name('trackShipment.notFound');

Route::prefix('oauth')
    ->as('oauth.')
    ->group(function () {
        Route::get('/{provider}/redirect', [OAuthController::class, 'redirect'])->name('redirect');
        Route::get('/{provider}/callback', [OAuthController::class, 'callback'])->name('callback');
        Route::post('/logout', [OAuthController::class, 'logout'])->name('logout');
    });

require __DIR__.'/auth.php';

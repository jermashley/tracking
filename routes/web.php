<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\DetailedTrackingController;
use App\Models\Company;
use App\Models\Image;
use App\Models\Theme;
use App\Models\User;
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
    ->middleware(['auth'])
    ->group(function () {
        // Admin routes

        // Dashboard
        Route::get('/dashboard', function () {
            $companies = Company::with(['logo', 'theme'])->get();

            return Inertia::render('admin/Dashboard', [
                'initialCompanies' => $companies,
            ]);
        })->name('dashboard');

        // Company routes

        // Company create
        Route::get('/company/create', function () {
            return Inertia::render('admin/company/Create');
        })->name('company.create');

        // Company show
        Route::get('/company/{company:uuid}', function (Company $company) {
            $company->load(['logo', 'banner', 'footer', 'theme']);

            return Inertia::render('admin/company/Edit', [
                'companyInitialValues' => $company,
            ]);
        })->name('company.show');

        // Theme routes

        // Theme index
        Route::get('themes', function () {
            $themes = Theme::all();

            return Inertia::render('admin/theme/Index', [
                'initialThemes' => $themes,
            ]);
        })->name('theme.index');

        // Theme create
        Route::get('themes/create', function (Theme $theme) {
            return Inertia::render('admin/theme/Create');
        })->name('theme.create');

        // Theme show
        Route::get('themes/{theme:uuid}', function (Theme $theme) {
            return Inertia::render('admin/theme/Edit', [
                'initialTheme' => $theme,
            ]);
        })->name('theme.show');

        // Images routes

        // Images index
        Route::get('images', function () {
            $images = Image::with('imageType')->get();

            return Inertia::render('admin/image/Index', [
                'initialImages' => $images,
            ]);
        })->name('image.index');

        // Tracking routes

        // Tracking index
        Route::get('tracking', function () {
            return Inertia::render('admin/tracking/Index');
        })->name('tracking.index');

        Route::get('userManagement', function () {
            return Inertia::render('admin/userManagement/Index', [
                'users' => User::with('roles')->get()->map(fn ($user) => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(), // returns a Collection of role names
                ])
            ]);
        })->name('userManagement.index');

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

<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\DetailedTrackingController;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Models\Company;
use App\Models\Image;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    if (Auth::check() && ! Auth::user()->can('company:read')) {
        return redirect(route('admin.tracking.index'));
    }

    if (Auth::check() && Auth::user()->can('company:read')) {
        return redirect(route('admin.companies.index'));
    }

    return redirect(route('login'));
})->name('home');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect(route('admin.dashboard'));
    }

    return Inertia::render('auth/Login');
})->name('login');

// Admin routes
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Company routes
        // Company index
        Route::get('/companies', function () {
            $companies = Company::with(['logo', 'theme'])->get();

            return Inertia::render('admin/companies/Index', [
                'initialCompanies' => $companies,
            ]);
        })->name('companies.index');

        // Company create
        Route::get('/companies/create', function () {
            return Inertia::render('admin/companies/Create');
        })->name('companies.create');

        // Company show
        Route::get('/companies/{company:uuid}', function (Company $company) {
            $company->load(['logo', 'banner', 'footer', 'theme']);

            return Inertia::render('admin/companies/Edit', [
                'companyInitialValues' => $company,
            ]);
        })->name('companies.show');

        // Theme routes
        // Theme index
        Route::get('themes', function () {
            $themes = Theme::all();

            return Inertia::render('admin/themes/Index', [
                'initialThemes' => $themes,
            ]);
        })->name('themes.index');

        // Theme create
        Route::get('themes/create', function (Theme $theme) {
            return Inertia::render('admin/themes/Create');
        })->name('themes.create');

        // Theme show
        Route::get('themes/{theme:uuid}', function (Theme $theme) {
            return Inertia::render('admin/themes/Edit', [
                'initialTheme' => $theme,
            ]);
        })->name('themes.show');

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

        // Admin Routes for Roles and Permissions
        Route::middleware(EnsureSuperAdmin::class)
            ->group(function () {
                // Users routes
                Route::get('users', function () {
                    $users = User::with('roles')->get();

                    return Inertia::render('admin/users/Index', [
                        'initialUsers' => $users,
                        'allRoles' => Role::all()->map(fn ($role) => [
                            'id' => $role->id,
                            'name' => $role->name,
                        ]),
                    ]);
                })->name('users.index');

                // Permissions routes
                Route::get('permissions', function () {
                    return Inertia::render('admin/permissions/Index', [
                        'initialPermissions' => Permission::all(),
                    ]);
                })->name('permissions.index');

                Route::get('/permissions/{permission}', function (Permission $permission) {
                    return Inertia::render('admin/permissions/Edit', [
                        'initialPermission' => $permission,
                    ]);
                })->name('permissions.show');

                Route::get('role', function () {
                    return Inertia::render('admin/role/Index', [
                        'roles' => Role::with('permissions')->get()->map(fn ($role) => [
                            'id' => $role->id,
                            'name' => $role->name,
                            'permissions' => $role->permissions->pluck('name'),
                        ]),
                    ]);
                })->name('role.index');

                Route::get('role/show/{role}', function (Role $role) {
                    $role->load('permissions');

                    return Inertia::render('admin/role/Edit', [
                        'initialRole' => $role,
                        'allPermissions' => \Spatie\Permission\Models\Permission::all()->map(fn ($permission) => [
                            'id' => $permission->id,
                            'name' => $permission->name,
                        ]),
                    ]);
                })->name('role.show');
            });
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

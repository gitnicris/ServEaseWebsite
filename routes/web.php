<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🌐 Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/messages', [PageController::class, 'messages'])->name('messages');
Route::get('/about', [PageController::class, 'about'])->name('about');

// 👑 Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

// 🧰 Provider Routes (Dashboard + Profile + Service CRUD)
Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

        // 📊 Provider Dashboard
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');

        // 👤 Profile Routes
        Route::get('/profile', [ProviderController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [ProviderController::class, 'updateProfile'])->name('profile.update');

        // ✅ Service CRUD Routes
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index'); // list + create form inside dashboard
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store'); // store service
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit'); // edit page
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update'); // update service
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy'); // delete service
    });

// 👤 Customer Routes
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    });

// 🏠 Redirect After Login
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'provider') {
        return redirect()->route('provider.dashboard');
    }

    return redirect()->route('customer.dashboard');
})->name('dashboard');

require __DIR__ . '/auth.php';

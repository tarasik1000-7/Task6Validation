<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/owners');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'locale'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ADMIN ONLY
    Route::middleware('role:admin')->group(function () {
        Route::delete('/car-photos/{photo}', [CarController::class, 'destroyPhoto'])
            ->name('car-photos.destroy');

        Route::resource('owners', OwnerController::class)->except(['index', 'show']);
        Route::resource('cars', CarController::class)->except(['index', 'show']);
    });

    // VIEW FOR ALL AUTH USERS
    Route::resource('owners', OwnerController::class)->only(['index', 'show']);
    Route::resource('cars', CarController::class)->only(['index', 'show']);
});

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'it'])) {
        abort(400);
    }

    session(['locale' => $locale]);
    return back();
})->name('lang.switch');

require __DIR__.'/auth.php';
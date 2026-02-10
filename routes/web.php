<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZiIndikatorController;
use App\Http\Controllers\ZiBuktiController;
use App\Http\Controllers\Admin\ZiAdminIndikatorController;
use App\Http\Controllers\Admin\ZiAdminUserController;
use App\Http\Controllers\Admin\ZiAdminUnitController;

/*
|--------------------------------------------------------------------------
| PUBLIC / UNOR
|--------------------------------------------------------------------------
*/

// Landing ZI (UNOR)
Route::get('/', [ZiIndikatorController::class, 'index'])
    ->middleware(['auth', 'only.unor'])
    ->name('zi.index');

// Upload bukti oleh UNOR
Route::post('/zi/bukti/upload', [ZiBuktiController::class, 'upload'])
    ->name('zi.bukti.upload');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN - MASTER INDIKATOR ZI
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth']) // nanti bisa ditambah role:superadmin
    ->name('admin.')
    ->group(function () {

        // LIST
        Route::get('/indikator', [ZiAdminIndikatorController::class, 'index'])
            ->name('indikator.index');

        // CREATE
        Route::get('/indikator/create', [ZiAdminIndikatorController::class, 'create'])
            ->name('indikator.create');

        Route::post('/indikator', [ZiAdminIndikatorController::class, 'store'])
            ->name('indikator.store');

        // EDIT
        Route::get('/indikator/{indikator}/edit', [ZiAdminIndikatorController::class, 'edit'])
            ->name('indikator.edit');

        // UPDATE
        Route::put('/indikator/{indikator}', [ZiAdminIndikatorController::class, 'update'])
            ->name('indikator.update');

        // (opsional) DELETE
        Route::delete('/indikator/{indikator}', [ZiAdminIndikatorController::class, 'destroy'])
            ->name('indikator.destroy');

            // ===== MASTER INDIKATOR =====
        Route::get('/indikator', [ZiAdminIndikatorController::class, 'index'])->name('indikator.index');
        Route::get('/indikator/create', [ZiAdminIndikatorController::class, 'create'])->name('indikator.create');
        Route::post('/indikator', [ZiAdminIndikatorController::class, 'store'])->name('indikator.store');
        Route::get('/indikator/{indikator}/edit', [ZiAdminIndikatorController::class, 'edit'])->name('indikator.edit');
        Route::put('/indikator/{indikator}', [ZiAdminIndikatorController::class, 'update'])->name('indikator.update');
        Route::delete('/indikator/{indikator}', [ZiAdminIndikatorController::class, 'destroy'])->name('indikator.destroy');

        // ===== MASTER USERS =====
        Route::get('/users', [ZiAdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [ZiAdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [ZiAdminUserController::class, 'store'])->name('users.store');

        // ===== MASTER UNIT =====
        Route::get('/units', [ZiAdminUnitController::class, 'index'])->name('units.index');
        Route::get('/units/create', [ZiAdminUnitController::class, 'create'])->name('units.create');
        Route::post('/units', [ZiAdminUnitController::class, 'store'])->name('units.store');
    });
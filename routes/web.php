<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnorIndikatorController;
use App\Http\Controllers\UnorBuktiController;
use App\Http\Controllers\Admin\UnorAdminIndikatorController;
use App\Http\Controllers\Admin\UnorAdminUserController;
use App\Http\Controllers\Admin\UnorAdminUnitController;
use App\Http\Controllers\UnkerIndikatorController;
use App\Http\Controllers\UnkerBuktiController;
use App\Http\Controllers\Admin\UnkerAdminIndikatorController;
use App\Http\Controllers\UptIndikatorController;
use App\Http\Controllers\UptBuktiController;
use App\Http\Controllers\Admin\UptAdminIndikatorController;
/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| UNOR (USER / TIM PENILAI)
|--------------------------------------------------------------------------
*/

Route::prefix('unor')
    ->middleware(['auth', 'only.unor'])
    ->group(function () {

        // Landing Unor
        Route::get('/', [UnorIndikatorController::class, 'index'])
            ->name('unor.index');

        // Upload bukti & simpan penilaian
        Route::post('/unor/bukti/upload', [UnorBuktiController::class, 'upload'])
            ->name('unor.bukti.upload');

        // Delete bukti (aman per unit)
        Route::delete('/unor/bukti/{id}', [UnorBuktiController::class, 'delete'])
            ->whereNumber('id')
            ->name('unor.bukti.delete');
    });


    /*
|--------------------------------------------------------------------------
| UNKER (USER / TIM PENILAI)
|--------------------------------------------------------------------------
*/

Route::prefix('unker')
    ->middleware(['auth', 'only.unker'])
    ->group(function () {

        // Landing Unker
        Route::get('/', [UnkerIndikatorController::class, 'index'])
            ->name('unker.index');

        // Upload bukti & simpan penilaian
        Route::post('/unker/bukti/upload', [UnkerBuktiController::class, 'upload'])
            ->name('unker.bukti.upload');

        // Delete bukti (aman per unit)
        Route::delete('/unker/bukti/{id}', [UnkerBuktiController::class, 'delete'])
            ->whereNumber('id')
            ->name('unker.bukti.delete');
    });

    /*
|--------------------------------------------------------------------------
| UPT (USER / TIM PENILAI)
|--------------------------------------------------------------------------
*/

Route::prefix('upt')
    ->middleware(['auth', 'only.upt'])
    ->group(function () {

        // Landing Upt
        Route::get('/', [UptIndikatorController::class, 'index'])
            ->name('upt.index');

        // Upload bukti & simpan penilaian
        Route::post('/upt/bukti/upload', [UptBuktiController::class, 'upload'])
            ->name('upt.bukti.upload');

        // Delete bukti (aman per unit)
        Route::delete('/upt/bukti/{id}', [UptBuktiController::class, 'delete'])
            ->whereNumber('id')
            ->name('upt.bukti.delete');
    });

/*
|--------------------------------------------------------------------------
| AUTH / PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN (SUPERADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'only.superadmin'])
    ->name('admin.')
    ->group(function () {

        /*
|--------------------------------------------------------------------------
| MASTER INDIKATOR UNOR
|--------------------------------------------------------------------------
*/

Route::prefix('unor')->group(function () {

    Route::get('/indikator', [UnorAdminIndikatorController::class, 'index'])
        ->name('indikator.index');

    Route::get('/indikator/create', [UnorAdminIndikatorController::class, 'create'])
        ->name('indikator.create');

    Route::post('/indikator', [UnorAdminIndikatorController::class, 'store'])
        ->name('indikator.store');

    Route::get('/indikator/{indikator}/edit', [UnorAdminIndikatorController::class, 'edit'])
        ->name('indikator.edit');

    Route::put('/indikator/{indikator}', [UnorAdminIndikatorController::class, 'update'])
        ->name('indikator.update');

    Route::delete('/indikator/{indikator}', [UnorAdminIndikatorController::class, 'destroy'])
        ->name('indikator.destroy');

});

/*
|--------------------------------------------------------------------------
| MASTER INDIKATOR UNKER
|--------------------------------------------------------------------------
*/

Route::prefix('unker')->group(function () {

    Route::get('/indikator', [UnkerAdminIndikatorController::class, 'index'])
        ->name('indikator.index');

    Route::get('/indikator/create', [UnkerAdminIndikatorController::class, 'create'])
        ->name('indikator.create');

    Route::post('/indikator', [UnkerAdminIndikatorController::class, 'store'])
        ->name('indikator.store');

    Route::get('/indikator/{indikator}/edit', [UnkerAdminIndikatorController::class, 'edit'])
        ->name('indikator.edit');

    Route::put('/indikator/{indikator}', [UnkerAdminIndikatorController::class, 'update'])
        ->name('indikator.update');

    Route::delete('/indikator/{indikator}', [UnkerAdminIndikatorController::class, 'destroy'])
        ->name('indikator.destroy');

});

/*
|--------------------------------------------------------------------------
| MASTER INDIKATOR UPT
|--------------------------------------------------------------------------
*/

Route::prefix('upt')->group(function () {

    Route::get('/indikator', [UptAdminIndikatorController::class, 'index'])
        ->name('indikator.index');

    Route::get('/indikator/create', [UptAdminIndikatorController::class, 'create'])
        ->name('indikator.create');

    Route::post('/indikator', [UptAdminIndikatorController::class, 'store'])
        ->name('indikator.store');

    Route::get('/indikator/{indikator}/edit', [UptAdminIndikatorController::class, 'edit'])
        ->name('indikator.edit');

    Route::put('/indikator/{indikator}', [UptAdminIndikatorController::class, 'update'])
        ->name('indikator.update');

    Route::delete('/indikator/{indikator}', [UptAdminIndikatorController::class, 'destroy'])
        ->name('indikator.destroy');

});


        /*
        |--------------------------------------------------------------------------
        | MASTER USERS
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [UnorAdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UnorAdminUserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UnorAdminUserController::class, 'store'])
            ->name('users.store');

        /*
        |--------------------------------------------------------------------------
        | MASTER UNITS
        |--------------------------------------------------------------------------
        */

        Route::get('/units', [UnorAdminUnitController::class, 'index'])
            ->name('units.index');

        Route::get('/units/create', [UnorAdminUnitController::class, 'create'])
            ->name('units.create');

        Route::post('/units', [UnorAdminUnitController::class, 'store'])
            ->name('units.store');
    });

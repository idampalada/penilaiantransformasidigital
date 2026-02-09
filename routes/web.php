<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZiIndikatorController;
use App\Http\Controllers\Admin\ZiAdminIndikatorController;
use App\Http\Controllers\ZiBuktiController;


Route::prefix('admin')
    ->middleware(['auth']) // nanti tambah role:superadmin
    ->group(function () {

    Route::get('/indikator', [ZiIndikatorController::class, 'index']);
    Route::get('/indikator/create', [ZiIndikatorController::class, 'create']);
    Route::post('/indikator', [ZiIndikatorController::class, 'store']);

});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('zi.index');
});

Route::get('/', [ZiIndikatorController::class, 'index']);

Route::post('/zi/bukti/upload', [ZiBuktiController::class, 'upload'])
    ->name('zi.bukti.upload');

Route::prefix('admin')
    ->middleware(['auth']) // nanti tambah role:superadmin
    ->group(function () {

        Route::get('/indikator', [ZiAdminIndikatorController::class, 'index']);
        Route::get('/indikator/create', [ZiAdminIndikatorController::class, 'create']);
        Route::post('/indikator', [ZiAdminIndikatorController::class, 'store']);

    });

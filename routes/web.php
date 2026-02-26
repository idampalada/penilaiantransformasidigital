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
    use App\Http\Controllers\DashboardController;
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

            Route::get('/', [UnorIndikatorController::class, 'index'])
                ->name('unor.index');

            // ✅ HAPUS "unor" DI DEPAN
            Route::post('/bukti/upload', [UnorBuktiController::class, 'upload'])
                ->name('unor.bukti.upload');

            Route::delete('/bukti/{id}', [UnorBuktiController::class, 'delete'])
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

            Route::post('/bukti/upload', [UnkerBuktiController::class, 'upload'])
        ->name('unker.bukti.upload');

    Route::delete('/bukti/{id}', [UnkerBuktiController::class, 'delete'])
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

            Route::post('/bukti/upload', [UptBuktiController::class, 'upload'])
        ->name('upt.bukti.upload');

    Route::delete('/bukti/{id}', [UptBuktiController::class, 'delete'])
        ->whereNumber('id')
        ->name('upt.bukti.delete');
        });

    /*
    |--------------------------------------------------------------------------
    | AUTH / PROFILE
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

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
        Route::prefix('unor')
            ->name('unor.')
            ->group(function () {
                Route::resource('indikator', UnorAdminIndikatorController::class);
            });

        /*
        |--------------------------------------------------------------------------
        | MASTER INDIKATOR UNKER
        |--------------------------------------------------------------------------
        */
        Route::prefix('unker')
            ->name('unker.')
            ->group(function () {
                Route::resource('indikator', UnkerAdminIndikatorController::class);
            });

        /*
        |--------------------------------------------------------------------------
        | MASTER INDIKATOR UPT
        |--------------------------------------------------------------------------
        */
        Route::prefix('upt')
            ->name('upt.')
            ->group(function () {
                Route::resource('indikator', UptAdminIndikatorController::class);
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

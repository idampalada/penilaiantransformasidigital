<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\OnlyUnor; // ✅ WAJIB ADA
use App\Http\Middleware\OnlyUnker; // ✅ WAJIB ADA
use App\Http\Middleware\OnlyUpt; // ✅ WAJIB ADA
use App\Http\Middleware\OnlySuperAdmin;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ REGISTER ALIAS MIDDLEWARE
        $middleware->alias([
            'only.unor' => OnlyUnor::class,
            'only.unker' => OnlyUnker::class,
            'only.upt' => OnlyUpt::class,
            'only.superadmin' => OnlySuperAdmin::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

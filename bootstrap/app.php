<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'checkRole' => \App\Http\Middleware\CheckRole::class,
            'Administrateur' => \App\Http\Middleware\AdminMiddleware::class,
            'Professeur' => \App\Http\Middleware\ProfesseurMiddleware::class,
            'Etudiant' => \App\Http\Middleware\EtudiantMiddleware::class,
            'Parent' => \App\Http\Middleware\ParentMiddleware::class,
            'Coordinateur' => \App\Http\Middleware\CoordinateurMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

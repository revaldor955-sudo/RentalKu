<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'staff' => \App\Http\Middleware\StaffMiddleware::class,
        'customer' => \App\Http\Middleware\CustomerMiddleware::class,
        'adminstaff' => \App\Http\Middleware\AdminStaffMiddleware::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if (! $request->routeIs('otp.*')) {
                return null;
            }

            $seconds = (int) ($e->getHeaders()['Retry-After'] ?? 60);
            $key = $request->routeIs('otp.resend') ? 'resend' : 'otp_code';

            return redirect()->route('otp.show')->withErrors([
                $key => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        });
    })->create();

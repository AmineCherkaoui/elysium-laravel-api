<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by( $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Trop de tentatives de connexion. Réessayez dans une minute.'
                    ], 429);
                });
        });


        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(1)
                ->by( $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Trop de tentatives. Réessayez dans une minute.'
                    ], 429);
                });
        });

           RateLimiter::for('commande', function (Request $request) {
            return Limit::perMinute(3)
                ->by( $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Trop de tentatives. Réessayez dans une minute.'
                    ], 429);
                });
        });
    }
}

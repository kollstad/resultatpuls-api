<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('write', function (Request $request) {
        $key = optional($request->user())->id
            ? 'uid:'.$request->user()->id
            : 'ip:'.$request->ip();

        // Justér verdien under ved behov (2/min midlertidig for test)
        return [
            Limit::perMinute(30)->by($key)->response(function () {
                return response()->json(['message' => 'Too many requests'], 429);
            }),
        ];
    });
    }
}

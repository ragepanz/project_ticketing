<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (request()->getHost() !== 'localhost' && request()->getHost() !== '127.0.0.1') {
            if (request()->hasHeader('X-Forwarded-Proto') && request()->header('X-Forwarded-Proto') === 'https' || str_contains(request()->getHost(), 'ngrok')) {
                URL::forceScheme('https');
            }
            URL::forceRootUrl(request()->getSchemeAndHttpHost());
        }

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip() ?: $request->user()?->id);
        });
    }
}

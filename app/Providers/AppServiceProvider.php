<?php

namespace App\Providers;

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
        if (app()->environment('production')) {
            $realPublic = env('REAL_PUBLIC_PATH');
            if ($realPublic) {
                app()->bind('path.public', function() use ($realPublic) {
                    return $realPublic;
                });
            }
        }
    }
}

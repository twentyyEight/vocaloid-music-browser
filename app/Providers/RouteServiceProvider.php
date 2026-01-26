<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/auth.php'));

        if (app()->environment('local') && file_exists(base_path('routes/sandbox.php'))) {
            Route::middleware('web')
                ->group(base_path('routes/sandbox.php'));
        }
    }
}

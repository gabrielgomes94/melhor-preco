<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private const ROUTES_DIR = 'src/Prices/price/Infrastructure/Routes/';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')
            ->group(base_path(self::ROUTES_DIR . 'web.php'));
    }
}

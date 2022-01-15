<?php


namespace Src\Calculator\Application\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private const ROUTES_DIR = 'src/Prices/calculator/Infrastructure/Routes/';

    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path(self::ROUTES_DIR . 'api.php'));
    }
}

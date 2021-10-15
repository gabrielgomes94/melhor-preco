<?php


namespace Src\Prices\Calculator\Application\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private const ROUTES_DIR = 'src/prices/calculator/Infrastructure/Routes/';

    public function boot()
    {
        Route::middleware('api')
            ->group(base_path(self::ROUTES_DIR . 'api.php'));
    }
}

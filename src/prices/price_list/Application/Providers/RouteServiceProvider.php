<?php


namespace Src\Prices\PriceList\Application\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private const ROUTES_DIR = 'src/prices/price_list/Infrastructure/Routes/';

    public function boot(): void
    {
        Route::middleware('web')
            ->group(base_path(self::ROUTES_DIR . 'web.php'));
    }
}

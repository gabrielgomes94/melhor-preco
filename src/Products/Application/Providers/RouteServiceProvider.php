<?php

namespace Src\Products\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    private const ROUTES_DIR = 'src/products/Infrastructure/Routes/';

    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path(self::ROUTES_DIR .  'api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path(self::ROUTES_DIR . 'web.php'));
    }
}

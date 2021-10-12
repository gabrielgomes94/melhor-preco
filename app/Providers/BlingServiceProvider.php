<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Products\Domain\Contracts\Clients\Product as ProductInterface;
use Src\Products\Domain\Contracts\Clients\ProductStore as ProductStoreInterface;
use Integrations\Bling\Products\Clients\Product;
use Integrations\Bling\Products\Clients\ProductStore;

class BlingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductInterface::class, Product::class);
        $this->app->bind(ProductStoreInterface::class, ProductStore::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

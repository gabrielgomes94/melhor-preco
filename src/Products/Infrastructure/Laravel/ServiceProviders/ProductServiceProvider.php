<?php

namespace Src\Products\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Categories\CategoryObserver;

class ProductServiceProvider extends ServiceProvider
{
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
        Category::observe(CategoryObserver::class);
    }
}

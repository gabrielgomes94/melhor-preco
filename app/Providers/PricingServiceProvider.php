<?php

namespace App\Providers;

use App\Repositories\Pricing\PricingRepository;
use App\Repositories\Pricing\ProductRepository;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;
use Barrigudinha\Pricing\Repositories\Contracts\Product as ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PricingServiceProvider extends ServiceProvider
{
    /**
     * Register repositories.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PricingRepositoryInterface::class, PricingRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}

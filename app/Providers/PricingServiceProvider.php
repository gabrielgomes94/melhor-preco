<?php

namespace App\Providers;

use App\Repositories\Pricing\PricingRepository;
use Barrigudinha\Pricing\Repositories\Contracts\Pricing as PricingRepositoryInterface;
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
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Repositories\PriceCampaignRepository;
use Barrigudinha\Pricing\Repositories\Contracts\CampaignRepository;
use Illuminate\Support\ServiceProvider;

class PricingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CampaignRepository::class, PriceCampaignRepository::class);
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

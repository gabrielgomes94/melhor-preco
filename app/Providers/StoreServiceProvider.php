<?php

namespace App\Providers;

use App\Repositories\Store\Store;
use Barrigudinha\Store\Repositories\StoreRepository;
use Illuminate\Support\ServiceProvider;

class StoreServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(StoreRepository::class, Store::class);
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}

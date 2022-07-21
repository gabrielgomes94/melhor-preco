<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Prices\Domain\Repositories\PromotionsRepository as RepositoryInterface;
use Src\Prices\Domain\Services\Promotions\FilterProfitableProducts as FilterProfitableProductsInterface;
use Src\Prices\Domain\Services\Promotions\ListPromotions as ListPromotionsInterface;
use Src\Prices\Domain\Services\Promotions\ShowPromotion as ShowPromotionInterface;
use Src\Prices\Infrastructure\Laravel\Repositories\PromotionsRepository;
//use Src\Prices\Infrastructure\Laravel\Services\FilterProfitableProducts;
use Src\Prices\Infrastructure\Laravel\Services\Promotions\ListPromotions;
//use Src\Prices\Infrastructure\Laravel\Services\Promotions\ShowPromotion;

class PromotionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Repositories
//        $this->app->bind(RepositoryInterface::class, PromotionsRepository::class);
//
//        // Services
//        $this->app->bind(
//            FilterProfitableProductsInterface::class,
//            FilterProfitableProducts::class
//        );
//
//        // Use Cases
//        $this->app->bind(ListPromotionsInterface::class, ListPromotions::class);
//        $this->app->bind(ShowPromotionInterface::class, ShowPromotion::class);
    }
}

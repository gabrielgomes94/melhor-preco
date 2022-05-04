<?php

namespace Src\Promotions\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Promotions\Domain\Repositories\PromotionRepository as RepositoryInterface;
use Src\Promotions\Domain\UseCases\Contracts\FilterProfitableProducts as FilterProfitableProductsInterface;
use Src\Promotions\Domain\UseCases\Contracts\ListPromotions as ListPromotionsInterface;
use Src\Promotions\Domain\UseCases\Contracts\ShowPromotion as ShowPromotionInterface;
use Src\Promotions\Domain\UseCases\ListPromotions;
use Src\Promotions\Domain\UseCases\ShowPromotion;
use Src\Promotions\Infrastructure\Laravel\Repositories\PromotionPromotionRepository;
use Src\Promotions\Domain\UseCases\FilterProfitableProducts;

class PromotionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(RepositoryInterface::class, PromotionPromotionRepository::class);

        // Services
        $this->app->bind(
            FilterProfitableProductsInterface::class,
            FilterProfitableProducts::class
        );

        // Use Cases
        $this->app->bind(ListPromotionsInterface::class, ListPromotions::class);
        $this->app->bind(ShowPromotionInterface::class, ShowPromotion::class);
    }
}

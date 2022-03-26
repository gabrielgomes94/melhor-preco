<?php

namespace Src\Promotions\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Promotions\Domain\Repositories\Repository as RepositoryInterface;
use Src\Promotions\Domain\Services\FilterProfitableProducts as FilterProfitableProductsInterface;
use Src\Promotions\Domain\UseCases\Contracts\ListPromotions as ListPromotionsInterface;
use Src\Promotions\Domain\UseCases\ListPromotions;
use Src\Promotions\Infrastructure\Laravel\Repositories\Repository;
use Src\Promotions\Infrastructure\Laravel\Services\FilterProfitableProducts;

class PromotionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(RepositoryInterface::class, Repository::class);

        // Services
        $this->app->bind(
            FilterProfitableProductsInterface::class,
            FilterProfitableProducts::class
        );

        // Use Cases
        $this->app->bind(ListPromotionsInterface::class, ListPromotions::class);
    }
}

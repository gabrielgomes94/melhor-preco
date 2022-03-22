<?php

namespace Src\Promotions\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Promotions\Domain\UseCases\Contracts\ListPromotions as ListPromotionsInterface;
use Src\Promotions\Domain\UseCases\ListPromotions;

class PromotionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(ListPromotionsInterface::class, ListPromotions::class);
    }
}

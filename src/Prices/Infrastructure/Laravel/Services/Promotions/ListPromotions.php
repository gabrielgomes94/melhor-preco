<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Promotions;

use Src\Prices\Domain\Services\Promotions\ListPromotions as ListPromotionsInterface;
use Src\Prices\Infrastructure\Laravel\Models\Promotion;

class ListPromotions implements ListPromotionsInterface
{
    public function __construct()
    {

    }

    public function list(): array
    {
        return Promotion::all()->all();
    }
}

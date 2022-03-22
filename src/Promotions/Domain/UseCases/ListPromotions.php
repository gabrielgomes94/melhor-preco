<?php

namespace Src\Promotions\Domain\UseCases;

use Src\Promotions\Domain\UseCases\Contracts\ListPromotions as ListPromotionsInterface;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion;

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

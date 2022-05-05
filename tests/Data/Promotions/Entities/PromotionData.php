<?php

namespace Tests\Data\Promotions\Entities;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion;

class PromotionData
{
    public static function create(array $overriden = []): Promotion
    {
        $promotion = new Promotion();
        $promotion->uuid = Uuid::fromString('c376d5f0-c601-4ca0-98c7-378aa6d7e94d');
        $data = array_merge(
            [
                'name' => 'Promoção de Teste',
                'discount' => 5.0,
                'begin_date' => Carbon::createFromFormat('d-m-Y', '01-01-2021'),
                'end_date' => Carbon::createFromFormat('d-m-Y', '31-01-2021'),
                'max_products_limit' => 100,
                'marketplace_subsidy' => 0.0,
                'marketplace_slug' => 'zxcv',
            ],
            $overriden
        );
        $promotion->fill($data);

        return $promotion;
    }
}

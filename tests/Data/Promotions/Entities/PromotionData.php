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
        $promotion->uuid = Uuid::uuid4();
        $data = array_merge(
            [
                'name' => 'Promoção de Teste',
                'discount' => 5.0,
                'begin_date' => Carbon::createFromFormat('d-m-Y', '01-01-2021'),
                'end_date' => Carbon::createFromFormat('d-m-Y', '31-01-2021'),
                'max_products_limit' => 100,
                'marketplace_subsidy' => 0.0,
            ],
            $overriden
        );
        $promotion->fill($data);

        return $promotion;
    }
}

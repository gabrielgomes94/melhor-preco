<?php

namespace Src\Promotions\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Promotions\Application\Data\PromotionSetup;
use Src\Promotions\Application\UseCases\CalculatePromotions;

class CalculatePromotionController extends Controller
{
    public function __construct(
        private CalculatePromotions $calculatePromotions
    ) {}

    public function __invoke()
    {
        $data = [
            'name' => 'Super Campanha de Março - 20% à vista',
            'subsidy' => [
                'seller' => 100,
                'marketplace' => 0,
            ],
            'discount' => [
                'minimum' => 0,
                'maximum' => 20,
            ],
            'maxProductsQuantity' => 150,
            'marketplaceSlug' => 'magalu',
            'minimumMargin' => 5,
            'promotionPeriod' => [
                'begin' => '2022-04-01',
                'end' => '2022-04-31',
            ]
        ];

        $data = new PromotionSetup($data);

        $prices = $this->calculatePromotions->calculate($data);
//        $data
        dd($prices);

    }
}

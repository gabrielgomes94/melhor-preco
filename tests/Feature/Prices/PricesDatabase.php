<?php

namespace Tests\Feature\Prices;

use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;

// @todo: verificar o melhor lugar para colocar a trait
trait PricesDatabase
{
    public function setDefaultDatabase(): void
    {
        MarketplaceData::magalu($this->user);
        MarketplaceData::shopee($this->user);

        $categoryCarriage = CategoryData::babyCarriage($this->user);
        $categoryChair = CategoryData::babyChair($this->user);

        ProductData::babyCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 889.90,
                    'profit' => 120.0,
                ],
            ],
            $categoryCarriage
        );

        ProductData::babyChair(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 499.90,
                    'profit' => 54.45,
                ],
            ],
            $categoryChair
        );

        ProductData::babyPacifier(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 9.90,
                    'profit' => 2.00,
                ],
            ]
        );

        ProductData::blanket(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 74.90,
                    'profit' => 21.00,
                ],
            ],
        );

        ProductData::redBlanket(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 74.90,
                    'profit' => 21.00,
                ],
            ],
        );

        ProductData::blueBlanket(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 74.90,
                    'profit' => 21.00,
                ],
            ],
        );

        ProductData::cradle(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 799.90,
                    'profit' => 95.9,
                ],
            ]
        );

        ProductData::kitCradleAndCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'store' => 'magalu',
                    'value' => 1499.90,
                    'profit' => 200.9,
                ],
            ]
        );
    }
}

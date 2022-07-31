<?php

namespace Tests\Data\Models\Prices;

use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;

trait PricesDatabase
{
    public function setDefaultDatabase(): void
    {
        /**
         * Marketplace with category commissions and no freight table
         */
        MarketplaceData::magalu($this->user);

        /**
         * Marketplace with single commission, maximum commission cap and no freight table
         */
        MarketplaceData::shopee($this->user);

        /**
         * Marketplace with single commission, and freight table
         */
        MarketplaceData::olist($this->user);

        /**
         * Marketplace with category commissions and freight table
         */
//        MarketplaceData::mercadoLivreClassic($this->user);

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
                    'margin' => (120.0 / 889.90) * 100,
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
                    'margin' => (54.45 / 499.90) * 100,
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
                    'margin' => (2.00 / 9.90) * 100,
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
                    'margin' => (21.00 / 74.90) * 100,
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
                    'margin' => (21.00 / 74.90) * 100,
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
                    'margin' => (21.00 / 74.90) * 100,
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
                    'margin' => (95.9 / 799.90) * 100,
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
                    'margin' => (200.90 / 1499.90) * 100,
                ],
            ]
        );
    }
}
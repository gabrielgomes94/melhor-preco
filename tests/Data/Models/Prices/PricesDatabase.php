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
        $magaluMarketplace = MarketplaceData::magalu($this->user);

        /**
         * Marketplace with single commission, maximum commission cap and no freight table
         */
        MarketplaceData::shopee($this->user);

        /**
         * Marketplace with single commission, and freight table
         */
        MarketplaceData::olist($this->user);

        $categoryCarriage = CategoryData::babyCarriage($this->user);
        $categoryChair = CategoryData::babyChair($this->user);

        ProductData::babyCarriage(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 889.90, 'profit' => 120.0]),
            ],
            $categoryCarriage
        );

        ProductData::babyChair(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 499.90, 'profit' => 54.45]),
            ],
            $categoryChair
        );

        ProductData::babyPacifier(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 9.90, 'profit' => 2.00]),
            ]
        );

        ProductData::blanket(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 74.90, 'profit' => 21.00]),
            ],
        );

        ProductData::redBlanket(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 74.90, 'profit' => 21.00]),
            ],
        );

        ProductData::blueBlanket(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 74.90, 'profit' => 21.00]),
            ],
        );

        ProductData::cradle(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 799.90, 'profit' => 95.90]),
            ]
        );

        ProductData::kitCradleAndCarriage(
            $this->user,
            [
                PriceData::build($magaluMarketplace, ['value' => 1499.90, 'profit' => 200.90]),
            ]
        );
    }
}

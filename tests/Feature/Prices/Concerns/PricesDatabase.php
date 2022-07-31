<?php

namespace Tests\Feature\Prices\Concerns;

use Src\Marketplaces\Domain\Models\Marketplace;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;

trait PricesDatabase
{
    private function and_given_i_have_a_marketplace_without_freight(): void
    {
        MarketplaceData::magalu($this->user);
    }

    private function and_given_i_have_a_marketplace_with_no_commission()
    {
        MarketplaceData::physicalStore($this->user);
    }

    private function and_given_i_have_a_marketplace_with_freight()
    {
        MarketplaceData::olist($this->user);
    }

    private function and_given_i_have_a_product(string $slug = 'magalu', string $erpId = '123456')
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        ProductData::babyCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'marketplace_erp_id' => $erpId,
                    'store' => $slug,
                    'value' => 889.90,
                    'profit' => null,
                    'margin' => null,
                ],
            ],
            $categoryCarriage
        );
    }

    private function and_given_i_have_a_product_priced_on_a_marketplace_with_freight()
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        ProductData::babyCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123458',
                    'marketplace_erp_id' => '123458',
                    'store' => 'olist',
                    'value' => 889.90,
                    'profit' => null,
                    'margin' => null,
                ],
            ],
            $categoryCarriage
        );
    }

    private function and_given_i_have_a_product_priced_on_a_marketplace_without_commission()
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        ProductData::babyCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123458',
                    'marketplace_erp_id' => '123459',
                    'store' => 'loja-fisica',
                    'value' => 889.90,
                    'profit' => null,
                    'margin' => null,
                ],
            ],
            $categoryCarriage
        );
    }

    private function and_given_i_have_a_cheap_product_priced_on_a_marketplace_with_freight()
    {
        ProductData::babyPacifier(
            $this->user,
            [
                [
                    'erp_id' => '123458',
                    'marketplace_erp_id' => '123458',
                    'store' => 'olist',
                    'value' => 19.90,
                ],
            ],
        );
    }

    private function and_given_i_have_a_marketplace_with_maximum_commission_cap(): Marketplace
    {
        return MarketplaceData::shopee($this->user);
    }
}

<?php

namespace Tests\Feature\Prices\Concerns;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Product\Product;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;

trait PricesDatabase
{
    private function given_i_have_a_marketplace(): Marketplace
    {
        return MarketplaceData::magalu($this->user);
    }

    private function given_i_have_a_marketplace_without_freight(): Marketplace
    {
        return MarketplaceData::magalu($this->user);
    }

    private function given_i_have_a_marketplace_with_no_commission(): Marketplace
    {
        return MarketplaceData::physicalStore($this->user);
    }

    private function given_i_have_a_marketplace_with_maximum_commission_cap(): Marketplace
    {
        return MarketplaceData::shopee($this->user);
    }

    private function given_i_have_a_marketplace_with_freight(): Marketplace
    {
        return MarketplaceData::olist($this->user);
    }

    private function given_i_have_a_product(Marketplace $marketplace): Product
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        $product = ProductData::babyCarriage(
            $this->user,
            [
                [
                    'erp_id' => '123456',
                    'marketplace_erp_id' => $marketplace->getErpId(),
                    'store' => $marketplace->getSlug(),
                    'value' => 889.90,
                    'profit' => null,
                    'margin' => null,
                ],
            ],
            $categoryCarriage
        );

        $invoice = PurchaseInvoiceData::makePersisted($this->user);
        $item = PurchaseItemsData::makePersisted($invoice, [
            'product_sku' => 1234,
            'unit_cost' => 100.0,
            'unit_price' => 150.0,
            'taxes' => [
                'icms' => [
                    'value' => 0.0,
                    'percentage' => 0,
                ],
                'ipi' => [
                    'value' => 40.0,
                    'percentage' => 0.4,
                ],
                'totalTaxes' => 40.0
            ],
            'ean' => '7908238800092',
            'uuid' => '65c0cdcf-fb24-4d3b-9042-9311ab739376',
        ]);

        $item->product()->associate($product);
        $item->save();

        return $product;
    }

    private function given_i_have_a_product_priced_on_a_marketplace_with_freight(): Product
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        return ProductData::babyCarriage(
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

    private function given_i_have_a_product_priced_on_a_marketplace_without_commission(): Product
    {
        $categoryCarriage = CategoryData::babyCarriage($this->user);

        return ProductData::babyCarriage(
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

    private function given_i_have_a_cheap_product(Marketplace $marketplace): Product
    {
        return ProductData::babyPacifier(
            $this->user,
            [
                [
                    'erp_id' => '123458',
                    'marketplace_erp_id' => $marketplace->getErpId(),
                    'store' => $marketplace->getSlug(),
                    'value' => 19.90,
                ],
            ],
        );
    }

    private function given_i_have_calculator_parameters(): array
    {
        return [
            'desiredPrice' => '919.90',
            'commission' => 19.0,
            'discount' => 0.0,
            'freight' => 12.0,
        ];
    }

    private function given_i_have_calculator_parameters_with_discount(): array
    {
        return [
            'desiredPrice' => '919.90',
            'commission' => 19.0,
            'discount' => 10.0,
            'freight' => 12.0,
        ];
    }

    private function given_i_have_calculator_parameters_without_freight(): array
    {
        return [
            'desiredPrice' => '919.90',
            'commission' => 19.0,
            'discount' => 0.0,
            'freight' => 0.0,
        ];
    }

    private function given_i_have_calculator_parameters_without_commission(): array
    {
        return [
            'desiredPrice' => '919.90',
            'commission' => 0.0,
            'discount' => 0.0,
            'freight' => 12.0,
        ];
    }
}

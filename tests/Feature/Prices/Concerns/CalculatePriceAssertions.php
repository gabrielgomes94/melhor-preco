<?php

namespace Tests\Feature\Prices\Concerns;

trait CalculatePriceAssertions
{
    private function then_the_marketplace_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.marketplace-404');
    }

    private function then_the_calculated_price_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.pricing.products.show');
    }

    private function then_the_product_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.product-404');
    }

    private function then_it_must_return_the_calculated_price_without_freight(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 90,77',
                'commissionRate' => 0.0,
                'costs' => 'R$ 626,57',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'magalu',
                'margin' => '29,59 %',
                'profit' => 'R$ 263,33',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 29.59,
                'profit' => 263.33,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_with_freight_value(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 177,98',
                'commissionRate' => 20.0,
                'costs' => 'R$ 739,52',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 25,74',
                'marketplaceSlug' => 'olist',
                'margin' => '16,90 %',
                'profit' => 'R$ 150,38',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 16.9,
                'profit' => 150.38,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_with_default_freight_value(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 3,98',
                'commissionRate' => 20.0,
                'costs' => 'R$ 17,37',
                'differenceICMS' => 'R$ 0,56',
                'freight' => 'R$ 5,00',
                'marketplaceSlug' => 'olist',
                'margin' => '12,67 %',
                'profit' => 'R$ 2,52',
                'purchasePrice' => 'R$ 6,75',
                'suggestedPrice' => 'R$ 19,89',
                'taxSimplesNacional' => 'R$ 1,08',
            ],
            'raw' => [
                'margin' => 12.67,
                'profit' => 2.52,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_without_commission(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 0,00',
                'commissionRate' => 0.0,
                'costs' => 'R$ 535,79',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'loja-fisica',
                'margin' => '39,79 %',
                'profit' => 'R$ 354,10',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 39.79,
                'profit' => 354.1,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_with_maximum_commission_cap(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 100,00',
                'commissionRate' => 12.0,
                'costs' => 'R$ 635,79',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'shopee',
                'margin' => '28,55 %',
                'profit' => 'R$ 254,10',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 28.55,
                'profit' => 254.1,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 177,98',
                'commissionRate' => 20.0,
                'costs' => 'R$ 739,52',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 25,74',
                'marketplaceSlug' => 'olist',
                'margin' => '16,90 %',
                'profit' => 'R$ 150,38',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 16.9,
                'profit' => 150.38,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_from_form(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 174,78',
                'commissionRate' => 19.0,
                'costs' => 'R$ 724,21',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 12,00',
                'marketplaceSlug' => 'olist',
                'margin' => '21,27 %',
                'profit' => 'R$ 195,69',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 919,90',
                'taxSimplesNacional' => 'R$ 50,13',
            ],
            'raw' => [
                'margin' => 21.27,
                'profit' => 195.69,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_from_form_with_discount(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 157,30',
                'commissionRate' => 19.0,
                'costs' => 'R$ 701,72',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 12,00',
                'marketplaceSlug' => 'olist',
                'margin' => '15,24 %',
                'profit' => 'R$ 126,19',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 827,91',
                'taxSimplesNacional' => 'R$ 45,12',
            ],
            'raw' => [
                'margin' => 15.24,
                'profit' => 126.19,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_from_form_without_freight(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 174,78',
                'commissionRate' => 19.0,
                'costs' => 'R$ 712,21',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'olist',
                'margin' => '22,58 %',
                'profit' => 'R$ 207,69',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 919,90',
                'taxSimplesNacional' => 'R$ 50,13',
            ],
            'raw' => [
                'margin' => 22.58,
                'profit' => 207.69,
            ],
        ]);
    }

    private function then_it_must_return_the_calculated_price_from_form_without_commission(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 0,00',
                'commissionRate' => 0.0,
                'costs' => 'R$ 549,42',
                'differenceICMS' => 'R$ 37,40',
                'freight' => 'R$ 12,00',
                'marketplaceSlug' => 'olist',
                'margin' => '40,27 %',
                'profit' => 'R$ 370,47',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 919,90',
                'taxSimplesNacional' => 'R$ 50,13',
            ],
            'raw' => [
                'margin' => 40.27,
                'profit' => 370.47,
            ],
        ]);
    }

    private function then_it_must_return_the_calculator_form(): void
    {
        $this->response->assertViewHas('calculatorForm', [
            'marketplaceName' => 'Olist',
            'marketplaceSlug' => 'olist',
            'commission' => 20.0,
            'discount' => 0.0,
            'desiredPrice' => 889.9,
            'productId' => '1234',
            'freight' => 25.74,
        ]);
    }

    private function then_it_must_return_product_info(): void
    {
        $this->response->assertViewHas('productInfo', [
            'id' => '1234',
            'header' => '1234 - Carrinho de Bebê',
            'currentPrice' => 'R$ 889,90',
        ]);
    }

    private function then_it_must_return_the_costs_form(): void
    {
        $this->response->assertViewHas('costsForm', [
            'purchasePrice' => 449.9,
            'taxICMS' => 12.0,
            'additionalCosts' => 0.0,
        ]);
    }

    private function then_it_must_return_the_marketplaces_list(): void
    {
        $this->response->assertViewHas('marketplacesList', [
            [
                'name' => 'Olist',
                'slug' => 'olist',
                'selected' => true,
            ],
        ]);
    }

    private function then_it_must_return_the_costs(): void
    {
        $this->response->assertViewHas('costs', [
            [
                'issuedAt' => '17/02/2021 09:55',
                'unitCost' => 'R$ 168,00',
                'costs' => [
                    'purchasePrice' => 'R$ 150,00',
                    'taxes' => 'R$ 40,00',
                    'freight' => 'R$ 10,00',
                    'insurance' => 'R$ 0,00',
                    'icms' => '0,00 %',
                ],
                'name' => 'Canguru Balbi Vermelho',
                'purchasePrice' => 'R$ 150,00',
                'quantity' => 5.0,
                'totalValue' => 'R$ 840,00',
                'purchaseItemUuid' => '65c0cdcf-fb24-4d3b-9042-9311ab739376',
                'productSku' => '1234',
                'supplier' => [
                    'name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                    'fiscalId' => '06981862000200',
                ],
            ],
        ]);
    }

    private function then_it_must_return_the_calculator_form_with_custom_input(): void
    {
        $this->response->assertViewHas('calculatorForm', [
            'marketplaceName' => 'Olist',
            'marketplaceSlug' => 'olist',
            'commission' => 19.0,
            'discount' => 0.0,
            'desiredPrice' => 919.9,
            'productId' => '1234',
            'freight' => 12.00,
        ]);
    }
}

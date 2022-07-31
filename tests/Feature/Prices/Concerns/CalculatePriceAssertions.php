<?php

namespace Tests\Feature\Prices\Concerns;

trait CalculatePriceAssertions
{
    private function and_it_must_return_the_calculated_price(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 90,77',
                'commissionRate' => 0.0,
                'costs' => 'R$ 626,58',
                'differenceICMS' => 'R$ 37,41',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'magalu',
                'margin' => '68,35 %',
                'priceId' => '17',
                'profit' => 'R$ 341,68',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 29.59,
                'profit' => 263.32,
            ],
        ]);
    }

    private function then_the_product_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.product-404');
    }

    private function and_it_must_return_the_calculated_price_without_freight(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 90,77',
                'commissionRate' => 0.0,
                'costs' => 'R$ 626,58',
                'differenceICMS' => 'R$ 37,41',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'magalu',
                'margin' => '29,59 %',
                'priceId' => '17',
                'profit' => 'R$ 263,32',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 29.59,
                'profit' => 263.32,
            ],
        ]);
    }

    private function and_it_must_return_the_calculated_price_with_freight_value()
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 177,98',
                'commissionRate' => 20.0,
                'costs' => 'R$ 739,53',
                'differenceICMS' => 'R$ 37,41',
                'freight' => 'R$ 25,74',
                'marketplaceSlug' => 'olist',
                'margin' => '16,90 %',
                'priceId' => '18',
                'profit' => 'R$ 150,37',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 16.9,
                'profit' => 150.37,
            ],
        ]);
    }

    private function then_the_calculated_price_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.pricing.products.show');
    }

    private function then_the_marketplace_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.marketplace-404');
    }

    private function and_it_must_return_the_calculated_price_with_default_freight_value(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 3,98',
                'commissionRate' => 20.0,
                'costs' => 'R$ 17,37',
                'differenceICMS' => 'R$ 0,56',
                'freight' => 'R$ 5,00',
                'marketplaceSlug' => 'olist',
                'margin' => '12,67 %',
                'priceId' => '19',
                'profit' => 'R$ 2,52',
                'purchasePrice' => 'R$ 6,75',
                'suggestedPrice' => 'R$ 19,89',
                'taxSimplesNacional' => 'R$ 1,08',
            ],
            'raw' => [
                'margin' => 12.67,
                'profit' => 2.52,
            ],
        ]);
    }

    private function and_it_must_return_the_calculated_price_without_commission(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 0,00',
                'commissionRate' => 0.0,
                'costs' => 'R$ 535,81',
                'differenceICMS' => 'R$ 37,41',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'loja-fisica',
                'margin' => '39,79 %',
                'priceId' => '20',
                'profit' => 'R$ 354,09',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 39.79,
                'profit' => 354.09,
            ],
        ]);
    }

    private function and_it_must_return_the_calculated_price_with_maximum_commission_cap(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 100,00',
                'commissionRate' => 12.0,
                'costs' => 'R$ 635,81',
                'differenceICMS' => 'R$ 37,41',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'shopee',
                'margin' => '28,55 %',
                'priceId' => '21',
                'profit' => 'R$ 254,09',
                'purchasePrice' => 'R$ 449,90',
                'suggestedPrice' => 'R$ 889,90',
                'taxSimplesNacional' => 'R$ 48,50',
            ],
            'raw' => [
                'margin' => 28.55,
                'profit' => 254.09,
            ],
        ]);
    }
}

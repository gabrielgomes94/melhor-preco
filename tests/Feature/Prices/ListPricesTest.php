<?php

namespace Tests\Feature\Prices;

use Tests\Data\Models\Prices\PricesDatabase;
use Tests\Feature\SimpleUser;
use Tests\FeatureTestCase;

class ListPricesTest extends FeatureTestCase
{
    use SimpleUser;
    use PricesDatabase;

    public function test_should_list_prices_in_marketplaces(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_the_prices();
    }

    public function test_should_filter_prices_in_list_by_minimum_margin(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_filtering_by_minimum_margin();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_prices_above_minimum_margin();
    }

    public function test_should_filter_prices_in_list_by_maximum_margin(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_filtering_by_maximum_margin();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_prices_below_maximum_margin();
    }

    public function test_should_filter_prices_in_list_by_margin_range(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_filtering_by_margin_range();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_prices_between_margin_range();
    }

    public function test_should_filter_prices_in_list_by_sku(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_by_sku();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_prices_related_with_the_sku();
    }

    public function test_should_filter_prices_in_list_by_category(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_by_category();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_prices_related_with_the_category();
    }

    public function test_should_filter_only_composition_product_prices(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_only_composition_product_prices();

        $this->then_the_price_list_page_must_be_rendered();
        $this->and_then_the_list_must_contains_only_the_composition_product_prices();
    }

    public function test_should_not_list_prices_when_marketplace_does_not_have_any_price(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_on_the_empty_marketplace();

        $this->then_the_empty_price_list_page_must_be_rendered();
    }

    public function test_should_not_list_prices_when_marketplace_does_exists(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_list_prices_on_an_inexistent_marketplace();

        $this->then_the_marketplace_error_page_must_be_rendered();
    }

    private function and_given_i_have_multiple_prices(): void
    {
        $this->setDefaultDatabase();
    }

    private function when_i_want_to_list_prices(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu');
    }

    private function when_i_want_to_list_prices_filtering_by_minimum_margin(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?minProfit=20.0');
    }

    private function when_i_want_to_list_prices_filtering_by_maximum_margin(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?maxProfit=20.0');
    }

    private function when_i_want_to_list_prices_filtering_by_margin_range(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?minProfit=10.0&maxProfit=12.0');
    }

    private function when_i_want_to_list_prices_by_sku(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?sku=1234');
    }

    private function when_i_want_to_list_prices_by_category(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?category=10');
    }

    private function when_i_want_to_list_only_composition_product_prices()
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/magalu?filterKits=1');
    }

    private function when_i_want_to_list_prices_on_the_empty_marketplace()
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/shopee');
    }

    private function when_i_want_to_list_prices_on_an_inexistent_marketplace()
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/precos/invalid-one');
    }

    private function then_the_price_list_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.pricing.prices.list');
        $this->response->assertViewHas('paginator');
    }

    private function then_the_empty_price_list_page_must_be_rendered()
    {
        $this->response->assertViewIs('pages.pricing.prices.empty-list');
        $this->response->assertViewHas('products', []);
    }

    private function then_the_marketplace_error_page_must_be_rendered()
    {
        $this->response->assertViewIs('pages.errors.marketplace-404');
    }

    private function and_then_the_list_must_contains_the_prices(): void
    {
        $this->response->assertViewHasAll([
            'currentMarketplace' => [
                'name' => 'Magalu',
                'slug' => 'magalu',
            ],
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => null,
                'maximumProfit' => null,
                'sku' => null,
            ],
            'marketplaces' => [
                [
                    'name' => 'Magalu',
                    'slug' => 'magalu',
                ],
                [
                    'name' => 'Shopee',
                    'slug' => 'shopee',
                ]
            ],
            'products' => [
                [
                    'sku' => '1234',
                    'name' => 'Carrinho de Bebê',
                    'price' => 'R$ 889,90',
                    'profit' => 'R$ 120,00',
                    'margin' => '13,48 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '987',
                    'name' => 'Cadeirinha para Carros',
                    'price' => 'R$ 499,90',
                    'profit' => 'R$ 54,45',
                    'margin' => '10,89 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '821',
                    'name' => 'Cobertor',
                    'price' => 'R$ 74,90',
                    'profit' => 'R$ 21,00',
                    'margin' => '28,04 %',
                    'quantity' => 10.0,
                    'variations' => [
                        [
                            'sku' => '822',
                            'name' => 'Cobertor Vermelho',
                            'price' => 'R$ 74,90',
                            'profit' => 'R$ 21,00',
                            'margin' => '28,04 %',
                            'quantity' => 10.0,
                            'variations' => [],
                        ],
                        [
                            'sku' => '823',
                            'name' => 'Cobertor Azul',
                            'price' => 'R$ 74,90',
                            'profit' => 'R$ 21,00',
                            'margin' => '28,04 %',
                            'quantity' => 10.0,
                            'variations' => [],
                        ]
                    ],
                ],
                [
                    'sku' => '777',
                    'name' => 'Chupeta',
                    'price' => 'R$ 9,90',
                    'profit' => 'R$ 2,00',
                    'margin' => '20,20 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '601',
                    'name' => 'Kit Berço e Carrinho',
                    'price' => 'R$ 1.499,90',
                    'profit' => 'R$ 200,90',
                    'margin' => '13,39 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '589',
                    'name' => 'Berço',
                    'price' => 'R$ 799,90',
                    'profit' => 'R$ 95,90',
                    'margin' => '11,99 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_prices_above_minimum_margin()
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => '20.0',
                'maximumProfit' => null,
                'sku' => null,
            ],
            'products' => [
                [
                    'sku' => '821',
                    'name' => 'Cobertor',
                    'price' => 'R$ 74,90',
                    'profit' => 'R$ 21,00',
                    'margin' => '28,04 %',
                    'quantity' => 10.0,
                    'variations' => [
                        [
                            'sku' => '822',
                            'name' => 'Cobertor Vermelho',
                            'price' => 'R$ 74,90',
                            'profit' => 'R$ 21,00',
                            'margin' => '28,04 %',
                            'quantity' => 10.0,
                            'variations' => [],
                        ],
                        [
                            'sku' => '823',
                            'name' => 'Cobertor Azul',
                            'price' => 'R$ 74,90',
                            'profit' => 'R$ 21,00',
                            'margin' => '28,04 %',
                            'quantity' => 10.0,
                            'variations' => [],
                        ]
                    ],
                ],
                [
                    'sku' => '777',
                    'name' => 'Chupeta',
                    'price' => 'R$ 9,90',
                    'profit' => 'R$ 2,00',
                    'margin' => '20,20 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_prices_below_maximum_margin(): void
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => null,
                'maximumProfit' => '20.0',
                'sku' => null,
            ],
            'products' => [
                [
                    'sku' => '1234',
                    'name' => 'Carrinho de Bebê',
                    'price' => 'R$ 889,90',
                    'profit' => 'R$ 120,00',
                    'margin' => '13,48 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '987',
                    'name' => 'Cadeirinha para Carros',
                    'price' => 'R$ 499,90',
                    'profit' => 'R$ 54,45',
                    'margin' => '10,89 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '601',
                    'name' => 'Kit Berço e Carrinho',
                    'price' => 'R$ 1.499,90',
                    'profit' => 'R$ 200,90',
                    'margin' => '13,39 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '589',
                    'name' => 'Berço',
                    'price' => 'R$ 799,90',
                    'profit' => 'R$ 95,90',
                    'margin' => '11,99 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_prices_between_margin_range(): void
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => '10.0',
                'maximumProfit' => '12.0',
                'sku' => null,
            ],
            'products' => [
                [
                    'sku' => '987',
                    'name' => 'Cadeirinha para Carros',
                    'price' => 'R$ 499,90',
                    'profit' => 'R$ 54,45',
                    'margin' => '10,89 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '589',
                    'name' => 'Berço',
                    'price' => 'R$ 799,90',
                    'profit' => 'R$ 95,90',
                    'margin' => '11,99 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_prices_related_with_the_sku()
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => null,
                'maximumProfit' => null,
                'sku' => '1234',
            ],
            'products' => [
                [
                    'sku' => '1234',
                    'name' => 'Carrinho de Bebê',
                    'price' => 'R$ 889,90',
                    'profit' => 'R$ 120,00',
                    'margin' => '13,48 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
                [
                    'sku' => '601',
                    'name' => 'Kit Berço e Carrinho',
                    'price' => 'R$ 1.499,90',
                    'profit' => 'R$ 200,90',
                    'margin' => '13,39 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_prices_related_with_the_category()
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => null,
                'maximumProfit' => null,
                'sku' => null,
            ],
            'products' => [
                0 => [
                    'sku' => '1234',
                    'name' => 'Carrinho de Bebê',
                    'price' => 'R$ 889,90',
                    'profit' => 'R$ 120,00',
                    'margin' => '13,48 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }

    private function and_then_the_list_must_contains_only_the_composition_product_prices()
    {
        $this->response->assertViewHasAll([
            'filter' => [
                'categories' => [
                    [
                        'name' => 'Carrinhos de Bebê',
                        'category_id' => '10',
                    ],
                    [
                        'name' => 'Cadeira de Bebê',
                        'category_id' => '11',
                    ]
                ],
                'minimumProfit' => null,
                'maximumProfit' => null,
                'sku' => null,
            ],
            'products' => [
                [
                    'sku' => '601',
                    'name' => 'Kit Berço e Carrinho',
                    'price' => 'R$ 1.499,90',
                    'profit' => 'R$ 200,90',
                    'margin' => '13,39 %',
                    'quantity' => 10.0,
                    'variations' => [],
                ],
            ],
        ]);
    }
}

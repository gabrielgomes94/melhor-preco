<?php

namespace Tests\Feature\Products;

use Src\Sales\Application\Models\SaleOrder;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class ShowProductDetailsTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_show_product_details(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_product();

        $this->when_i_want_to_see_product_details();

        $this->then_i_must_see_product_details_page();
    }

    public function test_should_handle_when_product_does_not_exists(): void
    {
        $this->given_i_am_a_logged_user();

        $this->when_i_want_to_see_product_details();

        $this->then_i_must_see_product_404_error_page();
    }

    private function given_i_have_a_product(): void
    {
        $shopee = MarketplaceData::shopee($this->user);
        $olist = MarketplaceData::magalu($this->user);
        $category = CategoryData::babyCarriage($this->user);

        $product = ProductData::babyCarriage(
            $this->user,
            [
                PriceData::build($olist, ['value' => 899.90, 'profit' => 95.25]),
                PriceData::build($shopee, ['value' => 899.90, 'profit' => 95.25]),
            ],
            $category
        );

        SaleOrderData::persisted(
            $this->user,
            [],
            [
                SaleItemData::make($product),
            ]
        );
    }

    private function when_i_want_to_see_product_details(): void
    {
        $this->response = $this->get('produtos/relatorios/detalhes/1234');
    }

    private function then_i_must_see_product_details_page(): void
    {
        $this->response->assertViewIs('pages.products.reports.product_details');

        $this->response->assertViewHas('costs', []);
        $this->response->assertViewHas('prices', [
            [
                'value' => 'R$ 899,90',
                'profit' => 'R$ 95,25',
                'marketplaceName' => 'Magalu',
                'marketplaceSlug' => 'magalu',
                'margin' => '10,58 %',
                'productSku' => '1234',
            ],
            [
                'value' => 'R$ 899,90',
                'profit' => 'R$ 95,25',
                'marketplaceName' => 'Shopee',
                'marketplaceSlug' => 'shopee',
                'margin' => '10,58 %',
                'productSku' => '1234',
            ],
        ]);

        $this->response->assertViewHas('product', [
            'sku' => '1234',
            'name' => 'Carrinho de Bebê',
            'weight' => '0,300 kg',
            'images' => [],
            'quantity' => 10.0,
            'category' => 'Carrinhos de Bebê',
            'dimensions' => '11 x 25 x 28 cm',
        ]);

        $this->response->assertViewHas('sales', [
            'lastSales' => [],
            'salesByMarketplace' => [
                [
                    'quantity' => 0,
                    'value' => 'R$ 0,00',
                    'slug' => 'magalu',
                    'storeName' => 'Magalu',
                ],
                [
                    'quantity' => 0,
                    'value' => 'R$ 0,00',
                    'slug' => 'shopee',
                    'storeName' => 'Shopee',
                ],
            ],
            'total' => [
                'quantity' => 0,
                'value' => 'R$ 0,00',
            ],
        ]);

        $this->response->assertViewHas('redirectLink', 'http://localhost');

    }

    private function then_i_must_see_product_404_error_page(): void
    {
        $this->response->assertViewIs('pages.errors.product-404');
    }
}

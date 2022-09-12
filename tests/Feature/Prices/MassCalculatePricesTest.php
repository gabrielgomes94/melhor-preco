<?php

namespace Tests\Feature\Prices;

use Src\Products\Domain\Models\Product;
use Tests\Feature\Prices\Concerns\PricesDatabase;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class MassCalculatePricesTest extends FeatureTestCase
{
    use UsersDatabase;
    use PricesDatabase;

    public function test_should_mass_calculate_prices(): void
    {
        $this->given_i_am_a_logged_user();
        $marketplace = $this->given_i_have_a_marketplace();
        $this->given_i_have_a_product($marketplace);
        $this->given_i_have_a_cheap_product($marketplace);

        $this->when_i_want_to_mass_calculate();

        $this->then_i_must_be_see_prices_list_page();
        $this->then_it_must_calculate();
    }

    private function when_i_want_to_mass_calculate(): void
    {
        $queryString = http_build_query([
            'value' => 1.234,
            'calculationType' => 'markup',
        ]);

        $this->response = $this->get("/calculadora/magalu/calcularEmMassa?$queryString");
    }

    private function then_it_must_calculate(): void
    {
//        $this->assertSame();
    }

    private function then_i_must_be_see_prices_list_page(): void
    {
        $this->response->assertViewIs('pages.pricing.prices.list');
        $this->response->assertViewHas('currentMarketplace', [
            'name' => 'Magalu',
            'slug' => 'magalu',
        ]);
        $this->response->assertViewHas('filter', [
            'categories' => [
                [
                    'name' => 'Carrinhos de Bebê',
                    'category_id' => '10',
                ],
            ],
            'minimumProfit' => null,
            'maximumProfit' => null,
            'sku' => null,
        ]);
        $this->assertContainsOnlyInstancesOf(Product::class, $this->response->viewData('paginator')->items());
        $this->response->assertViewHas('paginator');
        $this->response->assertViewHas('products', [
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'price' => 'R$ 601,33',
                'profit' => 'R$ 19,92',
                'margin' => '3,31 %',
                'variations' => [],
                'quantity' => 10.0,
            ],
            [
                'sku' => '777',
                'name' => 'Chupeta',
                'price' => 'R$ 9,02',
                'profit' => 'R$ 1,22',
                'margin' => '13,53 %',
                'variations' => [],
                'quantity' => 10.0,
            ],
        ]);
    }
}

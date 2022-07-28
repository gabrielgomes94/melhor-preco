<?php

namespace Tests\Feature\Prices;

use Tests\Data\Models\Prices\PricesDatabase;
use Tests\Feature\SimpleUser;
use Tests\FeatureTestCase;

class CalculatePriceTest extends FeatureTestCase
{
    use SimpleUser;
    use PricesDatabase;

    public function test_should_handle_when_product_does_not_exists(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_inexistent_price();

        $this->then_the_product_not_found_page_must_be_rendered();
    }

    public function test_should_handle_when_markeplace_doest_not_exists(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_inexistent_marketplace();

        $this->then_the_marketplace_not_found_page_must_be_rendered();
    }

    // @todo: fazer esse caso de teste ser o mais amplo
    public function test_should_calculate_price_from_database(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_database();

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price();
    }

    public function test_should_calculate_price_from_database_when_marketplace_has_no_freight(): void
    {

    }

    public function test_should_calculate_price_from_database_when_marketplace_has_default_freight(): void
    {

    }

    public function test_should_calculate_price_from_database_when_marketplace_has_no_commission(): void
    {

    }

    public function test_should_calculate_price_from_database_when_marketplace_has_maximum_commission_cap(): void
    {

    }

    public function test_should_calculate_price_from_form(): void
    {

    }

    public function test_should_calculate_price_from_form_when_discount_is_given(): void
    {

    }

    public function test_should_calculate_price_from_form_when_no_freight_is_given(): void
    {

    }

    public function test_should_calculate_price_from_form_when_no_commission_is_given(): void
    {

    }

    private function and_given_i_have_multiple_prices(): void
    {
        $this->setDefaultDatabase();
    }

    private function when_i_want_to_calculate_price_from_inexistent_price(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/magalu/produtos/inexistent-sku');
    }

    private function then_the_product_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.product-404');
    }

    private function when_i_want_to_calculate_price_from_inexistent_marketplace(): void
    {
        $this->response = $this->get('/calculadora/invalid-marketplace/produtos/987');
    }

    private function when_i_want_to_calculate_price_from_database(): void
    {
        $this->response = $this->get('/calculadora/magalu/produtos/987');
    }

    private function then_the_marketplace_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.marketplace-404');
    }

    private function then_the_calculated_price_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.pricing.products.show');
    }

    private function and_it_must_return_the_calculated_price(): void
    {
        $this->response->assertViewHas('calculatedPrice', [
            'formatted' => [
                'commission' => 'R$ 50,99',
                'commissionRate' => 0.0,
                'costs' => 'R$ 158,22',
                'differenceICMS' => 'R$ 8,23',
                'freight' => 'R$ 0,00',
                'marketplaceSlug' => 'magalu',
                'margin' => '68,35 %',
                'priceId' => '18',
                'profit' => 'R$ 341,68',
                'purchasePrice' => 'R$ 99,00',
                'suggestedPrice' => 'R$ 499,90',
                'taxSimplesNacional' => 'R$ 0,00',
            ],
            'raw' => [
                'margin' => 68.35,
                'profit' => 341.68,
            ],
        ]);
    }
}

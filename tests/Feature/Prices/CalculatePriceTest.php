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
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_inexistent_price();

        $this->then_the_product_not_found_page_must_be_rendered();
    }

    public function test_should_handle_when_markeplace_doest_not_exists(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_inexistent_marketplace();

        $this->then_the_marketplace_not_found_page_must_be_rendered();
    }

    public function test_should_calculate_price_from_database(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_multiple_prices();

        $this->when_i_want_to_calculate_price_from_database();

        $this->then_the_calculated_price_page_must_be_rendered();
    }

    public function test_should_calculate_price_from_form(): void
    {

    }

    private function and_given_i_have_multiple_prices(): void
    {
        $this->setDefaultDatabase();
    }

    private function when_i_want_to_calculate_price_from_inexistent_price(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/magalu/products/inexistent-sku');
    }

    private function then_the_product_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.product-404');
    }

    private function when_i_want_to_calculate_price_from_inexistent_marketplace(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/invalid-marketplace/products/987');
    }

    private function then_the_marketplace_not_found_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.errors.marketplace-404');
    }

    private function when_i_want_to_calculate_price_from_database(): void
    {
        $this->response = $this->actingAs($this->user)
            ->get('/calculadora/magalu/products/987');
    }

    private function then_the_calculated_price_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.pricing.products.show');
    }
}

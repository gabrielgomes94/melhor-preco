<?php

namespace Tests\Feature\Prices;

use phpDocumentor\Reflection\Types\Void_;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PricesDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Feature\Prices\Concerns\CalculatePriceAssertions;
use Tests\Feature\SimpleUser;
use Tests\FeatureTestCase;

class CalculatePriceTest extends FeatureTestCase
{
    use SimpleUser;
    use PricesDatabase;
    use \Tests\Feature\Prices\Concerns\PricesDatabase;
    use CalculatePriceAssertions;

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
//    public function test_should_calculate_price_from_database(): void
//    {
//        $this->given_i_am_a_logged_user();
//        $this->and_given_i_have_multiple_prices();
//
//        $this->when_i_want_to_calculate_price_from_database('987');
//
//        $this->then_the_calculated_price_page_must_be_rendered();
//        $this->and_it_must_return_the_calculated_price();
//    }

    public function test_should_calculate_price_from_database_when_marketplace_has_no_freight(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_without_freight();
        $this->and_given_i_have_a_product();

        $this->when_i_want_to_calculate_price_from_database('magalu', '1234');

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price_without_freight();
    }

    public function test_should_calculate_price_from_database_when_marketplace_has_freight(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_freight();
        $this->and_given_i_have_a_product_priced_on_a_marketplace_with_freight();

        $this->when_i_want_to_calculate_price_from_database('olist', '1234');

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price_with_freight_value();
    }

    public function test_should_calculate_price_from_database_when_it_has_freight_but_price_is_bellow_minimum_freight_value(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_freight();
        $this->and_given_i_have_a_cheap_product_priced_on_a_marketplace_with_freight();

        $this->when_i_want_to_calculate_price_from_database('olist', '777');

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price_with_default_freight_value();
    }

    public function test_should_calculate_price_from_database_when_marketplace_has_no_commission(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_no_commission();
        $this->and_given_i_have_a_product_priced_on_a_marketplace_without_commission();

        $this->when_i_want_to_calculate_price_from_database('loja-fisica', '1234');

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price_without_commission();
    }

    public function test_should_calculate_price_from_database_when_marketplace_has_maximum_commission_cap(): void
    {
        $this->given_i_am_a_logged_user();
        $marketplace = $this->and_given_i_have_a_marketplace_with_maximum_commission_cap();
        $this->and_given_i_have_a_product($marketplace->getSlug(), $marketplace->getErpId());

        $this->when_i_want_to_calculate_price_from_database($marketplace->getSlug(), '1234');

        $this->then_the_calculated_price_page_must_be_rendered();
        $this->and_it_must_return_the_calculated_price_with_maximum_commission_cap();
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

    private function when_i_want_to_calculate_price_from_inexistent_marketplace(): void
    {
        $this->response = $this->get('/calculadora/invalid-marketplace/produtos/987');
    }

    private function when_i_want_to_calculate_price_from_database(string $marketplaceSlug, string $sku): void
    {
        $this->response = $this->get("/calculadora/$marketplaceSlug/produtos/$sku");
    }
}

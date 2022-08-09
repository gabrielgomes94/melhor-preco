<?php

namespace Tests\Feature\Prices;

use Tests\Feature\Prices\Concerns\PricesDatabase;
use Tests\Feature\SimpleUser;
use Tests\FeatureTestCase;

class MassCalculatePricesTest extends FeatureTestCase
{
    use SimpleUser;
    use PricesDatabase;

    public function test_should_mass_calculate_prices(): void
    {
        $this->given_i_am_a_logged_user();
        $marketplace = $this->given_i_have_a_marketplace();
        $this->given_i_have_a_product($marketplace);
        $this->given_i_have_a_cheap_product($marketplace);

        $this->when_i_want_to_mass_calculate();

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
//        dd($this->response);
    }
}

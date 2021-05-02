<?php

namespace Tests\Unit\App\Presenters;

use App\Models\PriceCampaign;
use App\Presenters\Pricing\Data\DetailedPricing;
use App\Presenters\Pricing\Show;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function testShouldPresent(): void
    {
        // Set
        $presenter = new Show();
        $pricing = PriceCampaign::factory()->make();

        $expected = [
            "name" => "Cadeira de Alimentação",
            "products" => [
                [
                    "sku" => "1232",
                    "prices" => [
                        [
                            "store" => "magalu",
                            "value" => 102.2,
                            "profit" => 10.0,
                            "profit_margin" => 0.09784735812133072,
                        ],
                        [
                            "store" => "b2w",
                            "value" => 106.2,
                            "profit" => 14.0,
                            "profit_margin" => 0.1318267419962335,
                        ],
                    ],
                ],
              ],
              "stores" => ["Magazine Luiza", "B2W"],
        ];
        // Act
        $result = $presenter->present($pricing);

        // Assert
        $this->assertInstanceOf(DetailedPricing::class, $result);
        $this->assertSame($expected, $result->toArray());
    }
}

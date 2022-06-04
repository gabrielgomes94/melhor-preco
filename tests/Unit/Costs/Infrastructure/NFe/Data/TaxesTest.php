<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Math\Percentage;
use Tests\Data\NFe\ItemData;
use Tests\TestCase;

class TaxesTest extends TestCase
{
    public function test_should_instantiate_taxes(): void
    {
        // Arrange
        $data = ItemData::getNFeItem()['imposto'];
        $expected = [
            'totalTaxes' => 101.21,
            'ipi' => [
                'value' => 0.0,
                'percentage' => 0.0,
            ],
            'icms' => [
                'value' => 0.0,
                'percentage' => 0.0,
            ],
            'pis' => [
                'value' => 0.0,
                'percentage' => 0.0,
            ],
            'cofins' => [
                'value' => 0.0,
                'percentage' => 0.0,
            ],
        ];

        // Act
        $result = Taxes::fromArray($data);

        // Assert
        $this->assertEquals(
            new Tax('icms', 0, Percentage::fromPercentage(0)),
            $result->icms
        );
        $this->assertEquals(
            new Tax('ipi', 0, Percentage::fromPercentage(0)),
            $result->ipi
        );
        $this->assertEquals(
            new Tax('ii', 0, Percentage::fromPercentage(0)),
            $result->ii
        );
        $this->assertEquals(
            new Tax('pis', 0, Percentage::fromPercentage(0)),
            $result->pis
        );
        $this->assertEquals(
            new Tax('cofins', 0, Percentage::fromPercentage(0)),
            $result->cofins
        );
        $this->assertSame(101.21, $result->totalTaxes);
        $this->assertSame($expected, $result->toArray());
    }
}

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
            Tax::fromArray('icms', []),
            $result->icms
        );
        $this->assertEquals(
            Tax::fromArray('ipi', []),
            $result->ipi
        );
        $this->assertEquals(
            Tax::fromArray('ii', []),
            $result->ii
        );
        $this->assertEquals(
            Tax::fromArray('pis', []),
            $result->pis
        );
        $this->assertEquals(
            Tax::fromArray('cofins', []),
            $result->cofins
        );
        $this->assertSame(101.21, $result->totalTaxes);
        $this->assertSame($expected, $result->toArray());
    }
}

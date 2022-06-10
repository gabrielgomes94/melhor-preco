<?php

namespace Tests\Costs\Unit\Infrastructure\NFe\Mappers;

use Src\Costs\Infrastructure\NFe\Mappers\TaxesMapper;
use Tests\Data\NFe\ItemData;
use Tests\TestCase;

class TaxesMapperTest extends TestCase
{
    public function test_should_getIPI()
    {
        // Arrange
        $data = ItemData::getNFeItem();
        $expected = [
            'percentage' => 0.0,
            'value' => 0.0,
        ];

        // Act
        $result = TaxesMapper::getIPI($data['imposto']);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_GetCOFINS()
    {
        // Arrange
        $data = ItemData::getNFeItem();
        $expected = [
            'percentage' => 0.0,
            'value' => 0.0,
        ];

        // Act
        $result = TaxesMapper::getCOFINS($data['imposto']);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_GetPIS()
    {
        // Arrange
        $data = ItemData::getNFeItem();
        $expected = [
            'percentage' => 0.0,
            'value' => 0.0,
        ];

        // Act
        $result = TaxesMapper::getPIS($data['imposto']);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_GetICMS()
    {
        // Arrange
        $data = ItemData::getNFeItem();
        $expected = [
            'percentage' => 0.0,
        ];

        // Act
        $result = TaxesMapper::getICMS($data['imposto']);

        // Assert
        $this->assertSame($expected, $result);
    }
}

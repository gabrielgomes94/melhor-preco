<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Tests\Data\NFe\ItemData;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_should_make_product_from_array(): void
    {
        // Arrange
        $data = ItemData::getNFeItem();

        // Act
        $result = Product::fromArray($data);

        // Assert
        $this->assertInstanceOf(Product::class, $result);
        $this->assertSame(0.0, $result->discount);
        $this->assertSame('7290108861822', $result->ean);
        $this->assertSame('Mobile Take Along Magical Tales', $result->name);
        $this->assertSame(170.91, $result->price);
        $this->assertSame(2.0, $result->quantity);
        $this->assertSame(10.0, $result->totalFreight);
        $this->assertSame(5.0, $result->totalInsurance);
        $this->assertInstanceOf(Taxes::class, $result->taxes);
        $this->assertSame(5.0, $result->getUnitFreightValue());
        $this->assertSame(2.5, $result->getUnitInsuranceValue());
    }

    public function test_should_handle_calculations_when_quantity_is_zero(): void
    {
        // Arrange
        $data = ItemData::getNFeItem();
        $data['prod']['qCom'] = '0.0';

        // Act
        $result = Product::fromArray($data);

        // Assert
        $this->assertSame(0.0, $result->getUnitFreightValue());
        $this->assertSame(0.0, $result->getUnitInsuranceValue());
    }
}

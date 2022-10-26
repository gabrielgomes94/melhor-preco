<?php

namespace Src\Products\Domain\Models\ValueObjects;

//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class VariationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_variations()
    {
        // Arrange
        $user = UserData::persisted();
        $products = [
            ProductData::babyChair($user),
            ProductData::babyCarriage($user),
        ];

        // Act
        $instance = new Variations('1234', $products);

        // Assert
        $this->assertSame('1234', $instance->getParentSku());
        $this->assertEquals($products, $instance->get());
    }
}

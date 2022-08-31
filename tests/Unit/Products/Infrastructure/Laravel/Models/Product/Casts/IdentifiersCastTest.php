<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Models\ValueObjects\Identifiers;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class IdentifiersCastTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);

        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 889.90, 'profit' => null])
            ],
        );
        $casts = new IdentifiersCast();

        // Act
        $result = $casts->get($product, 'identifiers', null, []);

        // Assert
        $this->assertInstanceOf(Identifiers::class, $result);

        $identifiers = new Identifiers('1234', '15865921214', '7908238800092');
        $this->assertEquals($identifiers, $result);
    }

    public function test_should_not_get(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        $casts = new IdentifiersCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for model parameter');

        // Act
        $casts->get($user, 'identifiers', null, []);
    }

    public function test_should_set(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 889.90, 'profit' => null]),
            ],
        );
        $casts = new IdentifiersCast();
        $expected = [
            'sku' => '1234',
            'erp_id' => '15865921214',
            'ean' => '7908238800092',
        ];
        $identifiers = new Identifiers('1234', '15865921214', '7908238800092');

        // Act
        $result = $casts->set($product, 'identifiers', $identifiers, []);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_set(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        $casts = new IdentifiersCast();

        // Expects
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid type for value parameter');

        // Act
        $casts->set($user, 'identifiers', null, []);
    }
}

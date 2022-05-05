<?php

namespace Src\Promotions\Infrastructure\Laravel\Export;

use Mockery;
use Src\Promotions\Domain\Data\Entities\Promotion;
use Src\Promotions\Infrastructure\Laravel\Exports\PromotionSpredsheet;
use Tests\TestCase;

class PromotionSpredsheetTest extends TestCase
{
    public function test_should_instantiate_promotion_spreadsheet(): void
    {
        // Set
        $promotion = Mockery::mock(Promotion::class);
        $expected = collect([
            ['12345667'],
            ['12345668'],
            ['12345669'],
            ['12345670'],
            ['12345671'],
        ]);

        // Expected
        $promotion->expects()
            ->getProducts()
            ->andReturn([
                ['store_sku_id' => '12345667'],
                ['store_sku_id' => '12345668'],
                ['store_sku_id' => '12345669'],
                ['store_sku_id' => '12345670'],
                ['store_sku_id' => '12345671'],
            ]);

        // Act
        $promotionSpreadsheet = new PromotionSpredsheet($promotion);

        // Assert
        $this->assertEquals($expected, $promotionSpreadsheet->collection());
        $this->assertSame('A3', $promotionSpreadsheet->startCell());
    }
}

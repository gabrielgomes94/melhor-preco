<?php

namespace Tests\Unit\Barrigudinha\Product;

use Src\Products\Domain\Data\Dimensions;
use Tests\TestCase;

class DimensionsTest extends TestCase
{
    public function testShouldInstantiateDimensions()
    {
        // Set
        $depth = 10.0;
        $height = 12.2;
        $width = 20.75;

        // Act
        $result = new Dimensions($depth, $height, $width);

        // Assert
        $this->assertInstanceOf(Dimensions::class, $result);
        $this->assertSame(10.0, $result->depth());
        $this->assertSame(12.2, $result->height());
        $this->assertSame(20.75, $result->width());
    }
}

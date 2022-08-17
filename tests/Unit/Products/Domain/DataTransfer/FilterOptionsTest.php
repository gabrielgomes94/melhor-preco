<?php

namespace Src\Products\Domain\DataTransfer;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class FilterOptionsTest extends TestCase
{
    public function test_should_instantiate_filter_options(): void
    {
        // Act
        $instance = new FilterOptions(
            '1234',
            '10',
            3,
            25,
            Carbon::createFromFormat('Y-m-d', '2020-01-01'),
            Carbon::createFromFormat('Y-m-d', '2020-01-31'),
        );

        // Assert
        $this->assertSame('1234', $instance->sku);
        $this->assertSame('10', $instance->category);
        $this->assertSame(3, $instance->page);
        $this->assertSame(25, $instance->perPage);
        $this->assertInstanceOf(Carbon::class, $instance->beginDate);
        $this->assertInstanceOf(Carbon::class, $instance->endDate);
        $this->assertTrue($instance->hasCategory());
        $this->assertTrue($instance->hasSku());
    }
}

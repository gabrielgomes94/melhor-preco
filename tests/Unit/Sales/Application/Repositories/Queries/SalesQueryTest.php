<?php

namespace Src\Sales\Application\Repositories\Queries;

use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class SalesQueryTest extends TestCase
{
    public function test_should_build_query_for_sales_in_interval()
    {
        // Arrange
        $salesQuery = new SalesQuery();

        // Act
        $result = $salesQuery->salesInInterval();

        // Assert
        $this->assertInstanceOf(Builder::class, $result);
    }
}

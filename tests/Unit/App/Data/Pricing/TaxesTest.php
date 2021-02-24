<?php
namespace Tests\Unit\App\Data\Pricing;

use App\Data\Pricing\Taxes;
use Tests\TestCase;

class TaxesTest extends TestCase
{
    public function testShouldInstantiateTaxes(): void
    {
        // Actions
        $result = new Taxes([
            'ipi' => 0.04,
            'icmsDifference' => 0.16,
            'simplesNacional' => 0.06
        ]);

        // Assertions
        $this->assertSame(0.04, $result->ipi);
        $this->assertSame(0.16, $result->icmsDifference);
        $this->assertSame(0.06, $result->simplesNacional);
    }
}

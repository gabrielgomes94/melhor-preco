<?php
namespace Tests\Unit\App\Data\Pricing;

use App\Data\Pricing\ProductPrice;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductPriceTest extends TestCase
{
    public function testShouldInstantiateProductPrice(): void
    {
        // Set
        $data = [
            'sku' => '123',
            'price' => '25',
            'commission' => '5',
            'profit-margin' => null,
            'selling-price' => '75',
            'tax-ipi' => '4',
            'tax-icms' => '6',
            'freight' => null,
        ];
        $request = new Request($data);

        // Actions
        $result = ProductPrice::fromRequest($request);

        // Assertions
        $this->assertSame('123', $result->sku);
        $this->assertSame(25.0, $result->purchasePrice);
        $this->assertSame(0.05, $result->commission);
        $this->assertNull($result->profitMargin);
        $this->assertSame(75.0, $result->sellingPrice);
        $this->assertSame(0.04, $result->taxes->ipi);
        $this->assertSame(0.06, $result->taxes->icmsDifference);
        $this->assertSame(0.04, $result->taxes->simplesNacional);
        $this->assertSame(0.0, $result->freight);
    }
}

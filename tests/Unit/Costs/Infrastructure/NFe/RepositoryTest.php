<?php

namespace Src\Costs\Infrastructure\NFe;

use SimpleXMLElement;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Costs\Infrastructure\NFe\Mappers\PurchaseItemMapper;
use Src\Costs\Infrastructure\NFe\Services\CalculateUnitCost;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function test_should_get_items_from_xml(): void
    {
        // Arrange
        $xml = $this->getFixture('NFe/purchase-invoice.xml');
        $xml = new SimpleXMLElement($xml);

        $xmlReader = new Repository(
            new PurchaseItemMapper(
                new CalculateUnitCost()
            )
        );

        // Act
        $result = $xmlReader->getPurchaseItems($xml);

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $result);
    }
}

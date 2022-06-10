<?php

namespace Tests\Costs\Unit\Infrastructure\NFe;

use SimpleXMLElement;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Costs\Infrastructure\NFe\Mappers\PurchaseItemMapper;
use Src\Costs\Infrastructure\NFe\Repository;
use Src\Costs\Infrastructure\NFe\Services\CalculateUnitCost;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function test_should_get_items_from_xml(): void
    {
        // Arrange
        $xml = $this->getFixture('NFe/purchase-invoice.xml');
        $xml = new SimpleXMLElement($xml);

        $xmlReader = new Repository(new PurchaseItemMapper());

        // Act
        $result = $xmlReader->getPurchaseItems($xml);

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $result);
    }
}

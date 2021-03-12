<?php

namespace Tests\Unit\App\Rules;

use App\Rules\SkuList;
use PHPUnit\Framework\TestCase;

class SkuListTest extends TestCase
{
    public function testShouldPass(): void
    {
        // Set
        $skuList = new SkuList();
        $data = '1002 1003 1004 1005 1006 1007 1008 1009 1010 1100 1122';

        // Act
        $result = $skuList->passes('skus', $data);

        // Assert
        $this->assertTrue($result);
    }

    public function testShouldNotPass(): void
    {
        // Set
        $skuList = new SkuList();
        $data = 'batata 1002 abc 1004 codigo-sku 1006 1007 1008 1009 1010 1100 1122';

        // Act
        $result = $skuList->passes('skus', $data);

        // Assert
        $this->assertFalse($result);
    }

    public function testMessage(): void
    {
        // Set
        $skuList = new SkuList();
        $expected = 'SKU inválido. Digite SKUs válidos, separados por espaços';

        // Act
        $result = $skuList->message();

        // Assert
        $this->assertSame($expected, $result);
    }
}

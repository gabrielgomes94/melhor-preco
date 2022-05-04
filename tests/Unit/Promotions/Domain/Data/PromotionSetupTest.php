<?php

namespace Src\Promotions\Domain\Data\TransferObjects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Src\Math\Percentage;

class PromotionSetupTest extends TestCase
{
    public function test_should_create_promotion_setup(): void
    {
        // Set
        $expected = [
            'beginDate' => Carbon::createFromFormat('d-m-Y', '01-01-2021'),
            'endDate' => Carbon::createFromFormat('d-m-Y', '31-01-2021'),
            'discount' => Percentage::fromPercentage(5),
            'minimumMargin' => Percentage::fromPercentage(10),
            'marketplaceSubsidy' => Percentage::fromPercentage(0),
            'marketplaceSlug' => 'zxcv-store',
            'marketplaceName' => 'ZXCV',
            'productsMaxLimit' => 100,
            'name' => 'Promoção de Teste'
        ];

        // Actions
        $setup = PromotionSetup::fromArray($expected);

        // Assertions
        $this->assertEquals($expected['beginDate'], $setup->beginDate);
        $this->assertEquals($expected['endDate'], $setup->endDate);
        $this->assertSame(0.05, $setup->discount->getFraction());
        $this->assertSame(0.1, $setup->minimumMargin->getFraction());
        $this->assertSame(0.0, $setup->marketplaceSubsidy->getFraction());
        $this->assertSame('zxcv-store', $setup->marketplaceSlug);
        $this->assertSame('Promoção de Teste', $setup->name);
        $this->assertSame(100, $setup->productsMaxLimit);
    }
}

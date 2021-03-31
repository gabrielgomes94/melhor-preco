<?php

namespace Tests\Unit\App\Repositories\Pricing;

use App\Models\PriceCampaign;
use App\Repositories\Pricing\PricingRepository;
use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Data\Pricing as PricingData;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;
use Tests\TestCase;

class PricingRepositoryTest extends TestCase
{
    use RefreshDatabase;


    public function testShouldNotFindPricing(): void
    {
        // Set
        $repository = new PricingRepository();

        // Act
        $result = $repository->find('-1');

        // Assert
        $this->assertNull($result);
    }

    public function testShouldFindPricings(): void
    {
        // Set
        PriceCampaign::factory(1)->create();
        $repository = new PricingRepository();

        // Act
        $result = $repository->find('1');

        // Assert
        $this->assertInstanceOf(PriceCampaign::class, $result);
    }

    public function testShouldListAllPricings(): void
    {
        // Set
        PriceCampaign::factory(3)->create();
        $repository = new PricingRepository();

        // Act
        $result = $repository->all();

        // Assert
        $this->assertContainsOnlyInstancesOf(PriceCampaign::class, $result);
        $this->assertCount(3, $result);
    }

    public function testShouldCreatePricing()
    {
        // Set
        $repository = new PricingRepository();
        $pricing = new PricingData(
            name: 'Liquidação Carrinhos',
            products: [
                [
                    'sku' => '1122',
                    'stock' => '5',
                ],
            ],
            stores: [
                [
                    'code' => 'magalu',
                    'name' => 'Magazine Luiza',
                    'commission' => 12.8,
                    'extra_costs' => 0.0,
                ]
            ],
            id: '1122'
        );

        // Actions
        $result = $repository->create($pricing);

        // Assertions
        $this->assertTrue($result);
        $this->assertDatabaseCount('price_campaigns', 1);
    }
}

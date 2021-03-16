<?php
namespace Tests\Unit\App\Http\Requests\Pricing\Data;

use App\Http\Requests\Pricing\Data\CreateCampaign;
use Tests\TestCase;

class CreateCampaignTest extends TestCase
{
    public function testShouldInstantiateCreateCampaignDataObject(): void
    {
        // Set
        $data = [
            'name' => 'Precificação #001',
            'skuList' => ['100', '200', '350', '400', '500', '600'],
            'stores' => [
                'b2w',
                'mercado_livre',
                'magalu',
            ]
        ];

        // Act
        $result = new CreateCampaign($data);

        // Assert
        $this->assertSame($data, $result->toArray());
    }
}

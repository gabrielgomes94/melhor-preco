<?php


namespace Tests\Unit\App\Http\Requests\Pricing\Transformers;

use App\Http\Requests\Pricing\CreatePriceCampaignRequest;
use App\Http\Requests\Pricing\Data\CreateCampaign;
use App\Http\Requests\Pricing\Transformers\CreateCampaignTransformer;
use Tests\TestCase;

class CreateCampaignTransformerTest extends TestCase
{
    public function testShouldTransformCreateCampaignRequest(): void
    {
        // Set
        $data = [];
        $request = new CreatePriceCampaignRequest($data);
        $transformer = new CreateCampaignTransformer();

        // Act
        $result = $transformer->transform($request);

        // Assert
        $this->assertInstanceOf(CreateCampaign::class, $result);
//        $this->assertSame();
    }
}

<?php

namespace Tests\Feature\Promotions;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculatePromotionTest extends \Tests\TestCase
{
    use RefreshDatabase;

    public function test_logged_user_should_calculate_promotions(): void
    {

        // Set
//        $this->setProductsInDatabase();

        $user = User::factory()->create();

        $input = [
            'beginDate' => '01/01/2021',
            'endDate' => '31/01/2021',
            'discount' => 5.0,
            'marketplaceSlug' => 'test-marketplace',
            'marketplaceSubsidy' => 0.0,
            'promotionName' => 'Promoção de Teste',
            'productsMaxLimit' => 100,
        ];

        // Act
        $response = $this
            ->actingAs($user)
            ->post("/promocoes/calculator", $input);


    }


}

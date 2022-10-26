<?php

namespace Tests\Feature\Marketplaces;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Tests\Data\Models\Users\UserData;
use Tests\FeatureTestCase;

class CreateMarketplaceTest extends FeatureTestCase
{
    public function test_should_render_create_marketplace_view(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_want_to_see_the_create_page();

        $this->then_it_must_be_rendered_the_create_page();
    }

    public function test_should_create_marketplace(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_want_to_create_a_new_marketplace();

        $this->then_the_marketplace_must_be_inserted_on_database();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::persisted();
        $this->actingAs($this->user);
    }

    private function when_i_want_to_see_the_create_page(): void
    {
        $this->response = $this->get('/marketplaces/criar');
    }

    private function then_it_must_be_rendered_the_create_page()
    {
        $this->response->assertViewIs('pages.marketplaces.create');
    }

    private function when_i_want_to_create_a_new_marketplace()
    {
        $this->response = $this->post('/marketplaces/criar', [
            'status' => true,
            'commissionType' => 'categoryCommission',
            'erpId' => '123456',
            'name' => 'Magalu'
        ]);
    }

    private function then_the_marketplace_must_be_inserted_on_database()
    {
        $marketplace = Marketplace::where('erp_id', '123456')->where('user_id', $this->user->getId())->first();

        $this->assertInstanceOf(Marketplace::class, $marketplace);
    }
}

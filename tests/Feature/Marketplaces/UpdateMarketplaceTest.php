<?php

namespace Tests\Feature\Marketplaces;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\FeatureTestCase;

class UpdateMarketplaceTest extends FeatureTestCase
{
    public function test_should_render_edit_marketplace_page(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_an_marketplace();

        $this->when_i_want_to_see_the_edit_page();

        $this->then_it_must_be_rendered_the_edit_page();
    }

    public function test_should_update_marketplace(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_an_marketplace();

        $this->when_i_want_to_update_the_marketplace();

        $this->then_the_marketplace_must_be_updated_on_database();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
        $this->actingAs($this->user);
    }

    private function and_given_i_have_an_marketplace(): void
    {
        MarketplaceData::magalu($this->user);
    }

    private function when_i_want_to_see_the_edit_page(): void
    {
        $this->response = $this->get('/marketplaces/magalu/editar');
    }

    private function then_it_must_be_rendered_the_edit_page(): void
    {
        $this->response->assertViewIs('pages.marketplaces.edit');
        $this->response->assertViewHas(['marketplace' => [
            'commissionType' => 'uniqueCommission',
            'commissions' => [
                '12,80%',
            ],
            'erpId' => '123456',
            'isActive' => true,
            'name' => 'Magalu',
            'status' => 'Ativo',
            'slug' => 'magalu',
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]]);
    }

    private function when_i_want_to_update_the_marketplace(): void
    {
        $this->response = $this->post('/marketplaces/magalu/editar', [
            'status' => true,
            'commissionType' => 'uniqueCommission',
            'erpId' => '123456',
            'name' => 'Magazine Luiza',
        ]);
    }

    private function then_the_marketplace_must_be_updated_on_database(): void
    {
        $marketplace = Marketplace::where('uuid', '0ba73120-6944-4ac4-8357-cef9b410ff54')->first();
        $this->assertSame('Magazine Luiza', $marketplace->getName());
        $this->assertSame('magazine-luiza', $marketplace->getSlug());
        $this->assertSame('uniqueCommission', $marketplace->getCommission()->getType());
    }
}

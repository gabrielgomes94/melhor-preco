<?php

namespace Tests\Feature\Marketplaces;

use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\FeatureTestCase;

class ListMarketplacesTest extends FeatureTestCase
{
    public function test_should_list_marketplaces(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_many_marketplaces();

        $this->when_i_want_to_list_my_marketplaces();

        $this->then_the_marketplaces_list_page_must_be_rendered();
        $this->and_then_it_must_show_all_my_marketplaces();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
        $this->actingAs($this->user);
    }

    private function and_given_i_have_many_marketplaces(): void
    {
        MarketplaceData::persisted($this->user, [
            'uuid' => '0ba73120-6944-4bc4-8357-cef9b410ff43'
        ]);
        MarketplaceData::persisted($this->user, [
            'erp_id' => '23456',
            'name' => 'Olist',
            'slug' => 'olist',
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]);
        MarketplaceData::persisted($this->user, [
            'erp_id' => '43211',
            'name' => 'Shopee',
            'slug' => 'shopee',
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410df99',
        ]);
    }

    private function when_i_want_to_list_my_marketplaces(): void
    {
        $this->response = $this->get('/marketplaces/');
    }

    private function then_the_marketplaces_list_page_must_be_rendered(): void
    {
        $this->response->assertViewIs('pages.marketplaces.list');
    }

    private function and_then_it_must_show_all_my_marketplaces(): void
    {
        $this->response->assertViewHas([
            'marketplaces' => [
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '12,80%',
                    ],
                    'erpId' => '123456',
                    'isActive' => true,
                    'name' => 'Magalu',
                    'status' => 'Ativo',
                    'slug' => 'magalu',
                    'uuid' => '0ba73120-6944-4bc4-8357-cef9b410ff43',
                ],
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '12,80%',
                    ],
                    'erpId' => '23456',
                    'isActive' => true,
                    'name' => 'Olist',
                    'status' => 'Ativo',
                    'slug' => 'olist',
                    'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
                ],
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '12,80%',
                    ],
                    'erpId' => '43211',
                    'isActive' => true,
                    'name' => 'Shopee',
                    'status' => 'Ativo',
                    'slug' => 'shopee',
                    'uuid' => '0ba73120-6944-4ac4-8357-cef9b410df99',
                ],
            ],
        ]);
    }
}

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
        $this->user = UserData::persisted();
        $this->actingAs($this->user);
    }

    private function and_given_i_have_many_marketplaces(): void
    {
        MarketplaceData::magalu($this->user);
        MarketplaceData::olist($this->user);
        MarketplaceData::shopee($this->user);
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
                    'commissionType' => 'categoryCommission',
                    'commissions' => [
                        '12,80%',
                        '10,20%',
                    ],
                    'erpId' => '123456',
                    'isActive' => true,
                    'name' => 'Magalu',
                    'status' => 'Ativo',
                    'slug' => 'magalu',
                    'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
                    'freight' => [
                        'defaultValue' => 0.0,
                        'minimumFreightTableValue' => 0.0,
                        'freightTable' => [],
                    ],
                ],
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '20,00%',
                    ],
                    'erpId' => '123458',
                    'isActive' => true,
                    'name' => 'Olist',
                    'status' => 'Ativo',
                    'slug' => 'olist',
                    'uuid' => '7e664e49-bb7c-40e6-a481-a92cf61684c1',
                    'freight' => [
                        'defaultValue' => 5.0,
                        'minimumFreightTableValue' => 79.0,
                        'freightTable' => [
                            [
                                'initialCubicWeight' => '0,000',
                                'endCubicWeight' => '0,500',
                                'value' =>  'R$ 22,14',
                            ],
                            [
                                'initialCubicWeight' => '0,501',
                                'endCubicWeight' => '1,000',
                                'value' =>  'R$ 23,94',
                            ],
                            [
                                'initialCubicWeight' => '1,001',
                                'endCubicWeight' => '2,000',
                                'value' =>  'R$ 25,74',
                            ],
                            [
                                'initialCubicWeight' => '2,001',
                                'endCubicWeight' => '5,000',
                                'value' =>  'R$ 31,14',
                            ],
                            [
                                'initialCubicWeight' => '5,001',
                                'endCubicWeight' => '9,000',
                                'value' =>  'R$ 44,94',
                            ],
                            [
                                'initialCubicWeight' => '9,001',
                                'endCubicWeight' => '13,000',
                                'value' =>  'R$ 70,73',
                            ],
                            [
                                'initialCubicWeight' => '13,001',
                                'endCubicWeight' => '17,000',
                                'value' =>  'R$ 78,54',
                            ],
                            [
                                'initialCubicWeight' => '17,001',
                                'endCubicWeight' => '23,000',
                                'value' =>  'R$ 91,74',
                            ],
                            [
                                'initialCubicWeight' => '23,001',
                                'endCubicWeight' => '30,000',
                                'value' =>  'R$ 106,14',
                            ],
                            [
                                'initialCubicWeight' => '30,001',
                                'endCubicWeight' => '33,000',
                                'value' =>  'R$ 119,94',
                            ],
                            [
                                'initialCubicWeight' => '33,001',
                                'endCubicWeight' => '37,000',
                                'value' =>  'R$ 125,94',
                            ],
                            [
                                'initialCubicWeight' => '37,001',
                                'endCubicWeight' => '41,000',
                                'value' =>  'R$ 132,54',
                            ],
                            [
                                'initialCubicWeight' => '41,001',
                                'endCubicWeight' => '45,000',
                                'value' =>  'R$ 139,13',
                            ],
                            [
                                'initialCubicWeight' => '45,001',
                                'endCubicWeight' => '50,000',
                                'value' =>  'R$ 145,74',
                            ],
                            [
                                'initialCubicWeight' => '50,001',
                                'endCubicWeight' => '',
                                'value' =>  'R$ 152,94',
                            ],
                        ],
                    ],
                ],
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '12,00%',
                    ],
                    'erpId' => '123457',
                    'isActive' => true,
                    'name' => 'Shopee',
                    'status' => 'Ativo',
                    'slug' => 'shopee',
                    'uuid' => '9dbc1291-e85a-4d9f-a0d6-43f001643dcc',
                    'freight' => [
                        'defaultValue' => 0.0,
                        'minimumFreightTableValue' => 0.0,
                        'freightTable' => [],
                    ],
                ],
            ],
        ]);
    }
}

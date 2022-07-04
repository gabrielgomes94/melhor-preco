<?php

namespace Tests\Feature\Marketplaces;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\FeatureTestCase;

class SetCommissionTest extends FeatureTestCase
{
    private Marketplace $marketplace;

    public function test_should_render_set_category_commission_view(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_marketplace_with_category_commission_type();

        $this->when_i_want_to_see_the_set_commision_page();

        $this->then_i_must_see_the_set_commission_category_page();
    }

    public function test_should_render_set_unique_commission_view(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_marketplace_with_unique_commission_type();

        $this->when_i_want_to_see_the_set_commision_page();

        $this->then_i_must_see_the_set_commission_unique_page();
    }

    public function test_should_update_commission_by_category(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_marketplace_with_category_commission_type();

        $this->when_i_want_to_update_category_commission();

        $this->then_the_marketplace_commission_must_be_updated_in_database();
    }

    public function test_should_update_unique_commission(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_marketplace_with_unique_commission_type();

        $this->when_i_want_to_update_unique_commission();

        $this->then_the_marketplace_unique_commission_must_be_updated_in_database();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
        $this->actingAs($this->user);
    }

    private function and_given_i_have_a_marketplace_with_category_commission_type(): void
    {
        $this->marketplace = MarketplaceData::persisted($this->user, [
            'extra' => [
                'commissionType' => 'categoryCommission',
            ],
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]);

        CategoryData::persisted(user: $this->user, method: 'withoutParent');
        CategoryData::persisted($this->user);
    }

    private function when_i_want_to_see_the_set_commision_page(): void
    {
        $this->response = $this->get('/marketplaces/magalu/comissao/');
    }

    private function then_i_must_see_the_set_commission_category_page(): void
    {
        $this->response->assertViewIs('pages.marketplaces.set-commission.category');
        $this->response->assertViewHas([
            'categories' => [
                [
                    'name' => 'Carrinhos',
                    'categoryId' => '1',
                    'parentId' => '',
                    'commission' => null,
                ],
                [
                    'name' => 'Carrinhos / Carrinhos de supermercado',
                    'categoryId' => '10',
                    'parentId' => '1',
                    'commission' => null,
                ],
            ],
            'marketplaceSlug' => 'magalu',
        ]);
    }

    private function and_given_i_have_a_marketplace_with_unique_commission_type(): void
    {
        $this->marketplace = MarketplaceData::persisted($this->user, [
            'extra' => [
                'commissionType' => 'uniqueCommission',
            ],
            'uuid' => '0ba73120-6944-4ac4-8357-cef9b410ff54',
        ]);
    }

    private function then_i_must_see_the_set_commission_unique_page(): void
    {
        $this->response->assertViewIs('pages.marketplaces.set-commission.unique');
    }

    private function when_i_want_to_update_category_commission()
    {
        $this->response = $this->post('/marketplaces/magalu/definir-comissoes-por-categoria/', [
            'commission' => [
                10.0,
                12.2,
            ],
            'categoryId' => [
                1,
                10,
            ],
        ]);
    }

    private function then_the_marketplace_commission_must_be_updated_in_database(): void
    {
        $marketplace = Marketplace::where('uuid', '0ba73120-6944-4ac4-8357-cef9b410ff54')->first();
        $commissionJson = [
            'commissionType' => 'categoryCommission',
            'commissionValues' => [
                [
                    'categoryId' => '1',
                    'commission' => 10,
                ],
                [
                    'categoryId' => '10',
                    'commission' => 12.2,
                ],
            ],
        ];

        $this->assertSame($commissionJson, $marketplace->extra);
    }

    private function when_i_want_to_update_unique_commission(): void
    {
        $this->response = $this->post('/marketplaces/magalu/definir-comissao-unica/', [
            'commission' => 10.5,
        ]);
    }

    private function then_the_marketplace_unique_commission_must_be_updated_in_database(): void
    {
        $marketplace = Marketplace::where('uuid', '0ba73120-6944-4ac4-8357-cef9b410ff54')->first();
        $commissionJson = [
            'commissionType' => 'uniqueCommission',
            'commissionValues' => [
                [
                    'categoryId' => null,
                    'commission' => 10.5,
                ],
            ],
        ];

        $this->assertSame($commissionJson, $marketplace->extra);
    }
}

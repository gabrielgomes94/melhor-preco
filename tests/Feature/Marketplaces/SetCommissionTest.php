<?php

namespace Tests\Feature\Marketplaces;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class SetCommissionTest extends FeatureTestCase
{
    use UsersDatabase;
    private Marketplace $marketplace;

    public function test_should_render_set_category_commission_view(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_category_commission_type();

        $this->when_i_want_to_see_the_set_commision_page('magalu');

        $this->then_i_must_see_the_set_commission_category_page();
    }

    public function test_should_render_set_unique_commission_view(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_unique_commission_type();

        $this->when_i_want_to_see_the_set_commision_page('shopee');

        $this->then_i_must_see_the_set_commission_unique_page();
    }

    public function test_should_update_commission_by_category(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_category_commission_type();

        $this->when_i_want_to_update_category_commission();

        $this->then_the_marketplace_commission_must_be_updated_in_database();
    }

    public function test_should_update_unique_commission(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_unique_commission_type();

        $this->when_i_want_to_update_unique_commission();

        $this->then_the_marketplace_unique_commission_must_be_updated_in_database();
    }

    public function test_should_update_unique_commission_and_maximum_value_cap(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace_with_unique_commission_type();

        $this->when_i_want_to_update_unique_commission_and_set_maximum_value_cap();

        $this->then_the_marketplace_must_have_maximum_value_cap_in_commission();
    }

    private function and_given_i_have_a_marketplace_with_category_commission_type(): void
    {
        $this->marketplace = MarketplaceData::magalu($this->user);

        CategoryData::persisted(user: $this->user, method: 'withoutParent');
        CategoryData::persisted($this->user);
    }

    private function and_given_i_have_a_marketplace_with_unique_commission_type(): void
    {
        $this->marketplace = MarketplaceData::shopee($this->user);
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
                    'commission' => 12.8,
                    'spacing' => [
                        'level' => 0,
                        'componentSpace' => 12,
                    ],
                ],
                [
                    'name' => 'Carrinhos / Carrinhos de supermercado',
                    'categoryId' => '10',
                    'parentId' => '1',
                    'commission' => 10.2,
                    'spacing' => [
                        'level' => 1,
                        'componentSpace' => 11,
                    ],
                ],
            ],
            'marketplaceSlug' => 'magalu',
        ]);
    }

    private function then_i_must_see_the_set_commission_unique_page(): void
    {
        $this->response->assertViewIs('pages.marketplaces.set-commission.unique');
    }

    private function then_the_marketplace_commission_must_be_updated_in_database(): void
    {
        $marketplace = Marketplace::where('uuid', '0ba73120-6944-4ac4-8357-cef9b410ff54')->first();
        $commission = Commission::build(
            'categoryCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8), '1'),
                new CommissionValue(Percentage::fromPercentage(10.2), '10'),
            ])
        );

        $this->assertEquals($commission, $marketplace->commission);
    }

    private function then_the_marketplace_unique_commission_must_be_updated_in_database(): void
    {
        $marketplace = Marketplace::where('uuid', '9dbc1291-e85a-4d9f-a0d6-43f001643dcc')->first();
        $commission = Commission::build(
            'uniqueCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(10.5)),
            ]),
        );

        $this->assertEquals($commission, $marketplace->commission);
    }

    private function then_the_marketplace_must_have_maximum_value_cap_in_commission(): void
    {
        $marketplace = Marketplace::where('uuid', '9dbc1291-e85a-4d9f-a0d6-43f001643dcc')->first();

        $this->assertTrue($marketplace->getCommission()->hasMaximumValueCap());
        $this->assertEquals(100.0, $marketplace->getCommission()->getMaximumValueCap());
    }

    private function when_i_want_to_see_the_set_commision_page(string $marketplaceSlug): void
    {
        $this->response = $this->get("/marketplaces/$marketplaceSlug/comissao/");
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

    private function when_i_want_to_update_unique_commission(): void
    {
        $this->response = $this->post('/marketplaces/shopee/definir-comissao-unica/', [
            'commission' => 10.5,
        ]);
    }

    private function when_i_want_to_update_unique_commission_and_set_maximum_value_cap(): void
    {
        $this->response = $this->post('/marketplaces/shopee/definir-comissao-unica/', [
            'commission' => 10.5,
            'commissionMaximumCap' => 100,
        ]);
    }
}

<?php

namespace Tests\Feature\Marketplaces;

use Illuminate\Http\UploadedFile;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class SetFreightTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_render_edit_freight_page(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace();

        $this->when_i_want_to_go_to_edit_freight_page();

        $this->then_i_must_see_edit_freight_page();

    }

    public function test_should_update_freight(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace();

        $this->when_i_want_to_update_freight();

        $this->then_the_freight_must_be_updated();
        $this->and_i_must_be_redirected_back();
    }

    private function and_given_i_have_a_marketplace(): void
    {
        MarketplaceData::olist($this->user);
    }

    private function when_i_want_to_go_to_edit_freight_page(): void
    {
        $this->response = $this->get('marketplaces/olist/frete');
    }

    private function then_i_must_see_edit_freight_page(): void
    {
        $this->response->assertViewIs('pages.marketplaces.set-freight');
        $this->response->assertViewHas('commissionType', 'uniqueCommission');
        $this->response->assertViewHas('commissions', ['20,00%']);
        $this->response->assertViewHas('erpId', '123458');
        $this->response->assertViewHas('isActive', true);
        $this->response->assertViewHas('name', 'Olist');
        $this->response->assertViewHas('status', 'Ativo');
        $this->response->assertViewHas('slug', 'olist');
        $this->response->assertViewHas('uuid');
        $this->response->assertViewHas('freight');
    }

    private function when_i_want_to_update_freight()
    {
        $this->response = $this->post('marketplaces/olist/frete', [
            'baseValue' => '10.0',
            'minimumFreightTableValue' => '100.0',
            'freightTable' => UploadedFile::fake()->createWithContent(
                'frete.csv',
                "De (kg);Até (kg);Valor (R$)\n0;0.5;10\n0.5;1;12\n1;2;14\n"
            )
        ]);
    }

    private function then_the_freight_must_be_updated(): void
    {
        $marketplace = Marketplace::where('slug', 'olist')->first();
        $freight = new Freight(
            10.0,
            100.0,
            new FreightTable([
                new FreightTableComponent(10, 0, 0.5),
                new FreightTableComponent(12, 0.5, 1),
                new FreightTableComponent(14, 1, 2),
            ])
        );

        $this->assertEquals($freight, $marketplace->getFreight());
    }

    private function and_i_must_be_redirected_back(): void
    {
        $this->response->assertRedirect();
    }
}

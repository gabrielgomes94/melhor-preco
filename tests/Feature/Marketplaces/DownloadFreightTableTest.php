<?php

namespace Tests\Feature\Marketplaces;

use Maatwebsite\Excel\Facades\Excel;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Excel\Exports\FreightTableExport;
use Src\Marketplaces\Infrastructure\Excel\Exports\FreightTableTemplateExport;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class DownloadFreightTableTest extends FeatureTestCase
{
    use UsersDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->given_i_am_a_logged_user();
        Excel::fake();
    }

    public function test_should_download_freight_table_template(): void
    {
        $this->when_i_want_to_download_freight_table_template();

        $this->then_it_must_be_downloaded();
    }

    public function test_should_download_freight_table_from_marketplace(): void
    {
        $this->given_i_have_a_marketplace();

        $this->when_i_want_to_download_freight_table_from_marketplace();

        $this->then_the_freight_table_from_marketplace_must_be_downloaded();
    }

    private function given_i_have_a_marketplace(): void
    {
        $marketplace = MarketplaceData::magalu($this->user);
        $marketplace->setFreight(
            new Freight(
                freightTable: new FreightTable([
                    new FreightTableComponent(10.0, 0.0, 1.0),
                    new FreightTableComponent(12.0, 1.0, 2.0)
                ])
            )
        );
        $marketplace->save();
    }

    private function when_i_want_to_download_freight_table_template(): void
    {
        $this->response = $this->get('marketplaces/downloads/template-tabela-frete');
    }

    private function when_i_want_to_download_freight_table_from_marketplace()
    {
        $this->response = $this->get('marketplaces/downloads/magalu/tabela-frete');
    }

    private function then_it_must_be_downloaded(): void
    {
        Excel::assertDownloaded('template.csv', function(FreightTableTemplateExport $export) {
            return $export->array() === [
                    [
                        'De (kg)',
                        'Até (kg)',
                        'Valor (R$)'
                    ],
                ];
        });

    }

    private function then_the_freight_table_from_marketplace_must_be_downloaded()
    {
        Excel::assertDownloaded('tabela-frete-magalu.csv', function(FreightTableExport $export) {
            return $export->array() === [
                ['De (kg)', 'Até (kg)', 'Valor (R$)'],
                [0.0, 1.0, 10.0],
                [1.0, 2.0, 12.0],
            ];
        });
    }
}

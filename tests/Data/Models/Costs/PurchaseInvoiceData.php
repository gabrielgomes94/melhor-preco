<?php

namespace Tests\Data\Models\Costs;

use Carbon\Carbon;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;

class PurchaseInvoiceData
{
    public static function make(array $data = []): PurchaseInvoice
    {
        $data = array_merge_recursive(
            [
                'access_key' => '1234',
                'contact_name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'fiscal_id' => '06981862000200',
                'issued_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2021-02-17 09:55:41'),
                'number' => '248284',
                'series' => '1',
                'situation' => 'Registrada',
                'value' => 1000.0,
                'xml' => 'https://bling.com.br/relatorios/nfe.xml.php?s&chaveAcesso=1234',
                'link_danfe' => 'https://bling.com.br/doc.view.php?id=12346754',
            ],
            $data
        );

        return new PurchaseInvoice($data);
    }

    public static function makePersisted(array $data = []): PurchaseInvoice
    {
        $purchaseInvoice = self::make($data);
        $purchaseInvoice->save();

        return $purchaseInvoice;
    }
}

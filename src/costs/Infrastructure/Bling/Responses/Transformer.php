<?php

namespace Src\Costs\Infrastructure\Bling\Responses;

use Carbon\Carbon;
use Src\costs\Domain\Models\PurchaseInvoice;

class Transformer
{
    public static function transform(array $invoice): PurchaseInvoice
    {
        return new PurchaseInvoice([
            'access_key' => $invoice['chaveAcesso'],
            'contact_name' => $invoice['contato'],
            'fiscal_id' => $invoice['cnpj'],
            'issued_at' => Carbon::createFromFormat('Y-m-d H:i:s', $invoice['dataEmissao']),
            'number' => $invoice['numero'],
            'series' => $invoice['serie'],
            'situation' => $invoice['situacao'],
            'value' => $invoice['valorNota'],
            'xml' => $invoice['xml'],
            'link_danfe' => $invoice['linkDanfe'],
        ]);
    }
}

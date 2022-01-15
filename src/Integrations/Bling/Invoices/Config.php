<?php

namespace Src\Integrations\Bling\Invoices;

class Config
{
    public static function getPurchaseInvoice(): array
    {
        return [
            'base_uri' => 'https://Bling.com.br/Api/v2/notafiscal/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'filters' => 'tipo[E]',
            ],
        ];
    }

    public static function listPurchaseInvoices(): array
    {
        return [
            'base_uri' => 'https://Bling.com.br/Api/v2/notasfiscais/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'filters' => 'tipo[E]',
            ],
        ];
    }
}

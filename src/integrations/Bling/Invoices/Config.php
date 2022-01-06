<?php

namespace Src\Integrations\Bling\Invoices;

class Config
{
    public static function listPurchaseInvoices(): array
    {
        return [
            'base_uri' => 'https://Bling.com.br/Api/v2/notasfiscais/json',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'filters' => 'tipo[E]',
            ],
        ];
    }
}

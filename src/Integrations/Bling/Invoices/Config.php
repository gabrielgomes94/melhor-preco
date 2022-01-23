<?php

namespace Src\Integrations\Bling\Invoices;

class Config
{
    public static function getPurchaseInvoice(): array
    {
        return [
            'base_uri' => config('integrations.bling.invoices.get.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'filters' => 'tipo[E]',
            ],
        ];
    }

    public static function listPurchaseInvoices(): array
    {
        return [
            'base_uri' => config('integrations.bling.invoices.list.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'filters' => 'tipo[E]',
            ],
        ];
    }
}

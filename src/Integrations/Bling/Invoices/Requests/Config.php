<?php

namespace Src\Integrations\Bling\Invoices\Requests;

class Config
{
    public static function getPurchaseInvoiceOptions(): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'filters' => 'tipo[E]',
            ],
        ];
    }

    public static function getPurchaseInvoiceUrl(string $number, string $series): string
    {
        return "notafiscal/$number/{$series}/json/";
    }

    public static function listPurchaseInvoicesOptions(): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
                'filters' => 'tipo[E]',
            ],
        ];
    }

    public static function listPurchaseInvoicesUrl(int $page)
    {
        return "notasfiscais/page={$page}/json/";
    }
}

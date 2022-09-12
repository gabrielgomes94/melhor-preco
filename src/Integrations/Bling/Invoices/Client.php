<?php

namespace Src\Integrations\Bling\Invoices;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Invoices\Requests\Config;
use Src\Integrations\Bling\Invoices\Responses\Sanitizer;

class Client
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function get(string $erpToken, string $number, string $series): array
    {
        $response = Http::withOptions(
            Config::getPurchaseInvoiceOptions($erpToken)
        )->get(
            Config::getPurchaseInvoiceUrl($number, $series)
        );

        return $this->sanitizer->sanitize($response);
    }

    public function list(string $erpToken, int $page = 1): array
    {
        $response = Http::withOptions(
            Config::listPurchaseInvoicesOptions($erpToken)
        )->get(
            Config::listPurchaseInvoicesUrl($page)
        );

        return $this->sanitizer->sanitizeMultiple($response);
    }
}

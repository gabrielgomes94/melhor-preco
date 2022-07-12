<?php

namespace Src\Integrations\Bling\SaleOrders;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\SaleOrders\Requests\Config;
use Src\Integrations\Bling\SaleOrders\Responses\Sanitizer;

class Client
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function list(string $erpToken, int $page = 1): array
    {
        $response = Http::withOptions(
            Config::listSalesOptions($erpToken)
        )->get(
            Config::listSalesUrl($page)
        );

        return $this->sanitizer->sanitize($response);
    }
}

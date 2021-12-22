<?php


namespace Src\Integrations\Bling\Invoices;


use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Invoices\Responses\Sanitizer;

class Client
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function list()
    {
        $response = Http::withOptions(
            Config::listPurchaseInvoices()
        )->get('/');

        return $this->sanitizer->sanitizeMultiple($response);
    }
}

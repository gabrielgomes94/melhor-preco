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

    public function get(string $number, string $series)
    {
        $response = Http::withOptions(
            Config::getPurchaseInvoice()
        )->get("$number/{$series}/json/");

        return $this->sanitizer->sanitize($response);
    }

    public function list(int $page = 1)
    {
        $response = Http::withOptions(
            Config::listPurchaseInvoices()
        )->get("page={$page}/json/");

        return $this->sanitizer->sanitizeMultiple($response);
    }
}

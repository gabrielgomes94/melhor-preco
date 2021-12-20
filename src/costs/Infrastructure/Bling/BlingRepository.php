<?php

namespace Src\Costs\Infrastructure\Bling;

use Carbon\Carbon;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Integrations\Bling\Invoices\Client;

class BlingRepository implements ErpRepository
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function listPurchaseInvoice(): array
    {
        $data = $this->client->list();
        $invoices = [];

        foreach ($data as $invoice) {
            $invoice = $invoice['notafiscal'];

            if ($invoice['loja'] === '0') {
                $invoices[] = $this->getPurchaseInvoice($invoice);
            }
        }

        return $invoices;
    }

    private function getPurchaseInvoice(array $invoice): PurchaseInvoice
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
            'xml' => $invoice,
        ]);
    }
}

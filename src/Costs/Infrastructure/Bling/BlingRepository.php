<?php

namespace Src\Costs\Infrastructure\Bling;

use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Infrastructure\Bling\Responses\Factory;
use Src\Integrations\Bling\Invoices\Client;

class BlingRepository implements ErpRepository
{
    public function __construct(
        private readonly Client $client,
        private readonly Factory $responseFactory
    ) {
    }

    public function listPurchaseInvoice(): array
    {
        $page = 0;
        $invoicesCollection = [];

        do {
            $response = $this->client->list(++$page);
            $invoices = $this->responseFactory->make($response);

            $invoicesCollection = array_merge(
                $invoicesCollection,
                $invoices->data()
            );
        } while (!$invoices->isEmpty());

        return $invoicesCollection;
    }
}

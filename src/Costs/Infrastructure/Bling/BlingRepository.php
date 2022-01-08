<?php

namespace Src\Costs\Infrastructure\Bling;

use Carbon\Carbon;
use Exception;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Infrastructure\Bling\Responses\Factory;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Integrations\Bling\Invoices\Client;

class BlingRepository implements ErpRepository
{
    private Client $client;
    private Factory $responseFactory;

    public function __construct(Client $client, Factory $responseFactory)
    {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    public function listPurchaseInvoice(): array
    {
        $page = 0;
        $invoicesCollection = [];

        do {
            $response = $this->client->list(++$page);
            $invoices = $this->responseFactory->make($response);

            $invoicesCollection = array_merge(
                $invoicesCollection, $invoices->data()

            );
        } while(!empty($invoices->data()));

        return $invoicesCollection;
    }
}

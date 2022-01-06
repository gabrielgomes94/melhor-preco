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
        $data = $this->client->list();
        $response = $this->responseFactory->make($data);

        if ($response instanceof ErrorResponse) {
            throw new Exception($response->getErrorMessage());
        }

        return $response->data();
    }
}

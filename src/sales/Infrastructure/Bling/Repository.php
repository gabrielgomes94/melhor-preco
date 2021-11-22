<?php

namespace Src\Sales\Infrastructure\Bling;

use Src\Integrations\Bling\SaleOrders\Client;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Infrastructure\Bling\Responses\ResponseFactory;

class Repository implements ErpRepository
{
    private Client $client;
    private ResponseFactory $responseFactory;

    public function __construct(Client $client, ResponseFactory $responseFactory)
    {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    public function list(): array
    {
        $productsResponse = [];
        $page = 0;

        do {
            $response = $this->responseFactory->make(
                $this->client->list(++$page)
            );

            $productsResponse = array_merge($productsResponse, $response->data());
        } while(!$response->hasErrors());

        return $productsResponse ?? [];
    }
}

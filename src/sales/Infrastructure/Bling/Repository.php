<?php

namespace Src\Sales\Infrastructure\Bling;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\SaleOrders\Client;
use Src\Sales\Infrastructure\Bling\Responses\ResponseFactory;
use Src\Sales\Domain\Contracts\Repository\ErpRepository;

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
        $response = $this->client->list();

        return $this->responseFactory->make($response);
    }
}

<?php

namespace Src\Integrations\Bling\SaleOrders;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\SaleOrders\Responses\ResponseFactory;
use Src\Integrations\Bling\SaleOrders\Client;

class Repository
{
    private Client $client;
    private ResponseFactory $responseFactory;

    public function __construct(Client $client, ResponseFactory $responseFactory)
    {
        $this->client = $client;
        $this->responseFactory = $responseFactory;
    }

    public function list(): BaseResponse
    {
        $response = $this->client->list();

        return $this->responseFactory->make($response);
    }
}

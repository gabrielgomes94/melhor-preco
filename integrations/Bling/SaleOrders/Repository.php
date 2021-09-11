<?php

namespace Integrations\Bling\SaleOrders;

use Integrations\Bling\Base\Responses\BaseResponse;
use Integrations\Bling\SaleOrders\Responses\ResponseFactory;

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

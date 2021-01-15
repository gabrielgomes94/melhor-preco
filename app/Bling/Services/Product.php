<?php
namespace App\Bling\Services;

use App\Bling\Client;
use App\Bling\Response\ProductResponse;
use App\Bling\Response\Transformer\ProductTransformer;

class Product
{

    /**
     * @var Client
     */
    private $blingClient;

    public function __construct(Client $blingClient)
    {
        $this->blingClient = $blingClient;
    }

    public function get($sku, $filter = ''): ProductResponse
    {
        if ('stock' == $filter) {
            $response = $this->blingClient->getWithStock($sku);
            return $response;
        }

        $response = $this->blingClient->get($sku);

        return $response;
    }
}

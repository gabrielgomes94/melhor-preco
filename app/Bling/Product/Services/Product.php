<?php
namespace App\Bling\Product\Services;

use App\Bling\Product\Client;
use App\Bling\Product\Response\ProductResponse;
use App\Bling\Product\Response\Transformer\ProductTransformer;

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

        // To Do: Fix this
//        $response = $this->blingClient->get($sku);
        $response = $this->blingClient->getWithStock($sku);

        return $response;
    }
}

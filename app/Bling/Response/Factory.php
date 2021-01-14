<?php

namespace App\Bling\Response;

use App\Bling\Response\Transformer\ProductTransformer;
use Psr\Http\Message\ResponseInterface;

class Factory
{
    /**
     * @var ProductTransformer
     */
    private $transformer;

    public function __construct(ProductTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function make(ResponseInterface $response): ProductResponse
    {
        $data = json_decode((string) $response->getBody(), true);


        $responseData = $this->transformer->transform($data);


        $productResponse = new ProductResponse($responseData);

        return $productResponse;
    }
}

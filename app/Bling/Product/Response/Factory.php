<?php

namespace App\Bling\Product\Response;

use App\Bling\Product\Response\Transformer\ProductTransformer;
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
        $data = $this->decode($response);
        $responseData = $this->transformer->transform($data);

        return new ProductResponse($responseData);
    }

    public function makeWithError(string $message): ProductResponse
    {
        return new ProductResponse(null, $message);
    }

    private function decode(ResponseInterface $response)
    {
        return json_decode((string) $response->getBody(), true);
    }
}

<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\ProductIterator;
use Psr\Http\Message\ResponseInterface;

class ProductCollectionResponse extends BaseFactory
{
    public function make(ResponseInterface $productsResponse)
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->error->makeFromData(data: $data);
        }

        $products = $this->transformer->productsCollection($data);

        return new ProductIterator(data: $products);
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);;
        $data = $this->sanitizer->sanitizeMultiple($data);

        return  $data;
    }
}


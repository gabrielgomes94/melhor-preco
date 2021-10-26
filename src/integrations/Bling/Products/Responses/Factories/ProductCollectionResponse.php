<?php

namespace Src\Integrations\Bling\Products\Responses\Factories;

use Src\Integrations\Bling\Products\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Responses\ProductIterator;
use Src\Integrations\Bling\Products\Responses\Transformers\ProductsCollection;
use Illuminate\Http\Client\Response;

class ProductCollectionResponse extends BaseFactory
{
    public function make(Response $productsResponse): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transform($data);

        return new ProductIterator(data: $products);
    }

    public function makeWithStore(Response $productsResponse, string $store): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transformWithStore($data, $store);

        return new ProductIterator(data: $products);
    }

    private function getData(Response $response): array
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitizeMultiple($data);

        return  $data;
    }
}

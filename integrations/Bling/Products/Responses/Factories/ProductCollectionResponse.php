<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\ProductIterator;
use Integrations\Bling\Products\Transformers\ProductsCollection;
use Psr\Http\Message\ResponseInterface;

class ProductCollectionResponse extends BaseFactory
{
    public function make(ResponseInterface $productsResponse): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transform($data);

        return new ProductIterator(data: $products);
    }

    public function makeWithStore(ResponseInterface $productsResponse): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transformWithStore($data, 'b2w');

        $products = array_filter($products, function (array $product) {
            return !empty($product['store']);
        });

        return new ProductIterator(data: $products);
    }


    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitizeMultiple($data);

        return  $data;
    }
}

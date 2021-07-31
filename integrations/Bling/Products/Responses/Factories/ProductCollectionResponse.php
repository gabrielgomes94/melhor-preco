<?php

namespace Integrations\Bling\Products\Responses\Factories;

use App\Factories\Product\Product;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\ProductIterator;
use Integrations\Bling\Products\Responses\Transformers\ProductsCollection;
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

    public function makeWithStore(ResponseInterface $productsResponse, string $store): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transformWithStore($data, $store);

        return new ProductIterator(data: $products);
    }

    public function mergeResponses(array $responses): ProductIterator
    {
        $productList = [];

        foreach ($responses as $response) {
            foreach ($response->data() as $productResponse) {
                if(!$productResponse) {
                    continue;
                }

                foreach ($productList as $index => $product) {
                    if (!$product) {
                        continue;
                    }

                    if ($product->sku() === $productResponse->sku()) {
                        $store = $productResponse->stores()[0];
                        $productList[$index]->addStore($store);

                        continue 2;
                    }
                }

                $productList[] = $productResponse;
            }
        }

        return new ProductIterator(data: $productList);
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitizeMultiple($data);

        return  $data;
    }
}

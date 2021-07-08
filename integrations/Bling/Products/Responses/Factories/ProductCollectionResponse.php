<?php

namespace Integrations\Bling\Products\Responses\Factories;

use App\Factories\Product\Post;
use App\Factories\Product\Product;
use Barrigudinha\Product\Product as ProductData;
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

        $products = array_map(function (array $product) {
            return Product::buildFromERP($product);
        }, $products);

        return new ProductIterator(data: $products);
    }

    public function makeWithStore(ResponseInterface $productsResponse, string $store): BaseResponse
    {
        $data = $this->getData($productsResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $products = ProductsCollection::transformWithStore($data, $store);

        $products = array_filter($products, function (array $product) {
            return !empty($product['store']);
        });

        $products = array_map(function (array $product) {
            return Product::buildFromERP($product);
        }, $products);

        return new ProductIterator(data: $products);
    }

    public function mergeResponses(array $responses)
    {
        $productList = [];

        foreach ($responses as $response) {
            foreach ($response->data() as $productResponse) {
                foreach ($productList as $index => $product) {
                    if ($product->sku() === $productResponse->sku()) {
                        $post = $productResponse->posts()[0];
                        $productList[$index]->addPost($post);

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

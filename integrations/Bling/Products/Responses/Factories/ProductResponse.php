<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\Product;
use Integrations\Bling\Products\Responses\Transformers\Product as ProductTransformer;
use Integrations\Bling\Products\Responses\Transformers\Store as StoreTransformer;
use Psr\Http\Message\ResponseInterface;

class ProductResponse extends BaseFactory
{
    /**
     * @param array<string, ResponseInterface> $stores
     */
    public function make(
        ResponseInterface $productResponse,
        array $stores = []
    ) {
        $data = $this->getData($productResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $productData = ProductTransformer::transform($data);

        if ($stores) {
            foreach ($stores as $storeCode => $storeResponse) {
                $data = $this->getData($storeResponse);
                $productData->addStore(StoreTransformer::transform($data, $storeCode));
            }
        }

        return new Product(data: $productData);
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}

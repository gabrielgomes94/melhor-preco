<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\Product;
use Integrations\Bling\Products\Transformers\Sanitizer;
use Integrations\Bling\Products\Transformers\Transformer;
use Psr\Http\Message\ResponseInterface;

class ProductResponse extends BaseFactory
{
    /**
     * @param ResponseInterface[][]|null $stores
     */
    public function make(
        ResponseInterface $productResponse,
        ?array $stores = []
    ) {
        $data = $this->getData($productResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        $product = new Product(data: $this->transformer->product($data));

        if ($stores) {
            foreach ($stores as $storeCode => $storeResponse) {
                $data = $this->getData($storeResponse);
                $product->addStores($this->transformer->store($data));
            }
        }

        return $product;
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);;
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}

<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\ErrorResponse;
use Integrations\Bling\Products\Responses\ProductListResponse;
use Integrations\Bling\Products\Responses\Response;
use Integrations\Bling\Products\Responses\ProductResponse;
use Integrations\Bling\Products\Transformers\Sanitizer;
use Integrations\Bling\Products\Transformers\Transformer;
use Psr\Http\Message\ResponseInterface;

class Factory
{
    private Sanitizer $sanitizer;
    private Transformer $transformer;

    public function __construct(Transformer $transformer, Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
        $this->transformer = $transformer;
    }

    public function make(ResponseInterface $response): Response
    {
        $data = $this->getData($response);

        if (empty($data)) {
            return $this->makeError(error: 'Invalid response!');
        }

        if (isset($data['error'])) {
            return $this->makeError(error: $data['error']);
        }

        $product = $this->transformer->transform($data);

        return new ProductResponse(data: $product);
    }

    public function makeList(ResponseInterface $response): Response
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitizeMultiple($data);

        if (empty($data)) {
            return $this->makeError(error: 'Invalid response!');
        }

        if (isset($data['error'])) {
            return $this->makeError(error: $data['error']);
        }

        $products = $this->transformer->transformList($data);

        return new ProductListResponse(data: $products);
    }

    public function makeError(string $error): ErrorResponse
    {
        return new ErrorResponse(error: $error);
    }

    /**
     * @return ErrorResponse|array
     */
    public function makeStore(?ResponseInterface $response = null, string $store)
    {
        $data = $this->getData($response);

        if (empty($data)) {
            return $this->makeError(error: 'Invalid response!');
        }

        if (isset($data['error'])) {
            return $this->makeError(error: $data['error']);
        }

        $store = $this->transformer->transformStore($data, $store);

        return $store;
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);;
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}

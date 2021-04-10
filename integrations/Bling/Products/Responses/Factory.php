<?php

namespace Integrations\Bling\Products\Responses;

use Integrations\Bling\Products\Responses\Responses\ErrorResponse;
use Integrations\Bling\Products\Responses\Responses\ProductResponse;
use Integrations\Bling\Products\Responses\Responses\Response;
use Integrations\Bling\Products\Responses\Responses\StoreResponse;
use Integrations\Bling\Products\Responses\Transformers\Sanitizer;
use Integrations\Bling\Products\Responses\Transformers\Transformer;
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

        $data = $this->getData($response);
        $product = $this->transformer->transform($data);

        return new ProductResponse(data: $product);
    }

    public function makeError(string $error): ErrorResponse
    {
        return new ErrorResponse(error: $error);
    }

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
//        dd($store);
//        return new StoreResponse($store);
    }

    private function error(?ResponseInterface $response, string $error = ''): ?string
    {
        if (!$response) {
            return $error;
        }

        $data = $this->getData($response);

        if (empty($data)) {
            return 'Invalid response!';
        }

        if (isset($data['error'])) {
            return $data['error'];
        }

        return null;
    }



//    private function makeWithError(string $message): ResponseBuilder
//    {
//        return new ResponseBuilder(error: $message);
//    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);;
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}

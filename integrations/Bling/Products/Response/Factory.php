<?php

namespace Integrations\Bling\Products\Response;

use Integrations\Bling\Products\Response\Transformers\Sanitizer;
use Integrations\Bling\Products\Response\Transformers\Transformer;
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

    public function make(?ResponseInterface $response = null, string $error = ''): ProductResponse
    {
        if (!$response) {
            return $this->makeWithError($error);
        }

        $data = $this->getData($response);

        if (empty($data)) {
            return $this->makeWithError('Invalid response!');
        }

        if (isset($data['error'])) {
            return $this->makeWithError($data['error']);
        }

        $product = $this->transformer->transform($data);
        return new ProductResponse(data: $product);
    }

    private function makeWithError(string $message): ProductResponse
    {
        return new ProductResponse(error: $message);
    }

    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);;
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}

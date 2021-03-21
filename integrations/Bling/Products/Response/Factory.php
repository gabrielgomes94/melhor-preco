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

    public function make(ResponseInterface $response): ProductResponse
    {
        $data = $this->decode($response);

        $data = $this->sanitizer->sanitize($data);

        if (isset($data['error'])) {
            $message = $data['error']['msg'] ?? '';

            return $this->makeWithError($message);
        }

        $product = $this->transformer->transform($data);
        return new ProductResponse(data: $product);
    }

    public function makeWithError(string $message): ProductResponse
    {
        return new ProductResponse(error: $message);
    }

    private function decode(ResponseInterface $response): array
    {
        return json_decode((string) $response->getBody(), true);
    }
}

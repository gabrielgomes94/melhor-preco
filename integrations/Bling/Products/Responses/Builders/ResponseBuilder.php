<?php

namespace Integrations\Bling\Products\Responses\Builders;

use Integrations\Bling\Products\Responses\Contracts\ResponseBuilder as ResponseBuilderInterface;
use Integrations\Bling\Products\Responses\Factories\Factory;
use Integrations\Bling\Products\Responses\Response;
use Psr\Http\Message\ResponseInterface;

class ResponseBuilder implements ResponseBuilderInterface
{
    private Factory $factory;
    private Response $response;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function product(ResponseInterface $response): self
    {
        $this->response = $this->factory->make($response);

        return $this;
    }

    public function products(ResponseInterface $response): self
    {
        $this->response = $this->factory->makeList($response);

        return $this;
    }

    public function withError(string $error): self
    {
        $this->response = $this->factory->makeError(error: $error);

        return $this;
    }

    public function withStore(string $store, ResponseInterface $response): self
    {
        $store = $this->factory->makeStore($response, $store);

        if (is_array($store)) {
            $this->response->addStores($store);
        }

        return $this;
    }

    public function get(): Response
    {
        return $this->response;
    }
}

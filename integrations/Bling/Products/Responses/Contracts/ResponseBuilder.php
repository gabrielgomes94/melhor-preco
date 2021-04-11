<?php

namespace Integrations\Bling\Products\Responses\Contracts;

use Integrations\Bling\Products\Responses\Factory;
use Integrations\Bling\Products\Responses\Response;
use Psr\Http\Message\ResponseInterface;

interface ResponseBuilder
{
    public function __construct(Factory $factory);

    public function product(ResponseInterface $response): self;

    public function withStore(string $store, ResponseInterface $response): self;

    public function get(): Response;
}

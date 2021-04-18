<?php

namespace Integrations\Bling\Products\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Request
{
    public function get(string $uri): ResponseInterface;

    public function getStore(string $sku, string $store): ResponseInterface;
}

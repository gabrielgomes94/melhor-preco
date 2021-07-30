<?php

namespace Integrations\Bling\Products\Responses\Contracts;

use Integrations\Bling\Products\Data\Product;

interface Response
{
    /**
     * @return mixed|Product|Product[]
     */
    public function data();

    public function errors(): array;

    public function hasErrors(): bool;
}

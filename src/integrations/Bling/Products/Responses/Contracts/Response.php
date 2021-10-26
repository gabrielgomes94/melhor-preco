<?php

namespace Src\Integrations\Bling\Products\Responses\Contracts;

use Src\Integrations\Bling\Products\Responses\Data\Product;

interface Response
{
    /**
     * @return mixed|\Src\Integrations\Bling\Products\Responses\Data\Product|\Src\Integrations\Bling\Products\Responses\Data\Product[]
     */
    public function data();

    public function errors(): array;

    public function hasErrors(): bool;
}

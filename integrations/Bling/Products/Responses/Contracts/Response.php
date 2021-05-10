<?php

namespace Integrations\Bling\Products\Responses\Contracts;

use Barrigudinha\Product\Product;

interface Response
{
    /**
     * @return mixed|Product|Product[]
     */
    public function data();

    public function errors(): array;

    public function hasErrors(): bool;
}

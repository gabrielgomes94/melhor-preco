<?php

namespace Integrations\Bling\Products\Response\Contracts;

use Barrigudinha\Product\Product;

interface ProductResponse
{
    public function errors(): array;

    public function hasErrors(): bool;

    public function product(): ?Product;
}

<?php

namespace Integrations\Bling\Products\Responses\Contracts;

use Barrigudinha\Product\Product;

interface Response
{
    public function errors(): array;

    public function hasErrors(): bool;

    public function product(): ?Product;

    public function addStores(array $store);
}

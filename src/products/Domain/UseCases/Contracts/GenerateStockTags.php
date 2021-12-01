<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface GenerateStockTags
{
    public function generate(array $products): array;
}

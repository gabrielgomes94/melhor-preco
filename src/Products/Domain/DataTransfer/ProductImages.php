<?php

namespace Src\Products\Domain\DataTransfer;

class ProductImages
{
    public function __construct(
        public readonly string $name,
        public readonly string $sku,
        public readonly array $images
    )
    {}
}

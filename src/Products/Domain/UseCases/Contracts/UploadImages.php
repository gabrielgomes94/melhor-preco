<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface UploadImages
{
    public function execute(string $sku, string $name, string $brand, array $images): bool;
}

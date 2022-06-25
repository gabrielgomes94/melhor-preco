<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface UploadImages
{
    public function execute(
        string $erpToken,
        string $sku,
        string $name,
        string $brand,
        array $images
    ): bool;
}

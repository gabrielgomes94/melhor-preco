<?php

namespace Src\Products\Domain\Services;

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

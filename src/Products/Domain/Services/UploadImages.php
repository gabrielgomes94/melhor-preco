<?php

namespace Src\Products\Domain\Services;

use Src\Products\Domain\DataTransfer\ProductImages;
use Src\Users\Domain\Models\User;

interface UploadImages
{
    public function execute(ProductImages $productImages, User $user): bool;
}

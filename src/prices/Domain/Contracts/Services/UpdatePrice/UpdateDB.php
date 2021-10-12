<?php

namespace Src\Prices\Domain\Contracts\Services\UpdatePrice;

use Src\Products\Domain\Entities\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}

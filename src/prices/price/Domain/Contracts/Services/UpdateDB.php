<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}

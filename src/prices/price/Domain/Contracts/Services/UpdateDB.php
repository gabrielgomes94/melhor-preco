<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Post\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}

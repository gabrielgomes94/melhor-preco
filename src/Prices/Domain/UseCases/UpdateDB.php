<?php

namespace Src\Prices\Domain\UseCases;

use Src\Products\Domain\Models\Post\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}

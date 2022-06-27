<?php

namespace Src\Prices\Domain\UseCases\Products;

use Src\Products\Domain\Models\Post\Post;

interface UpdateDBCommand
{
    public function execute(Post $post): bool;
}

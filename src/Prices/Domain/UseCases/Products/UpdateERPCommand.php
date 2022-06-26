<?php

namespace Src\Prices\Domain\UseCases\Products;

use Src\Products\Domain\Models\Post\Post;

// To Do: Refatorar o código para liberar os métodos comentados na interface e remover o execute()
interface UpdateERPCommand
{
    public function execute(string $sku, Post $post): bool;

//    public function updatePrice(string $sku, Post $post): bool;
//
//    public function updateImages(string $sku, Product $product): bool;
}

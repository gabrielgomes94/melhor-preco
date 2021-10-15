<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Post;
use Src\Products\Domain\Entities\Product;

// To Do: Refatorar o código para liberar os métodos comentados na interface e remover o execute()
interface UpdateERP
{
    public function execute(string $sku, Post $post): bool;

//    public function updatePrice(string $sku, Post $post): bool;
//
//    public function updateImages(string $sku, Product $product): bool;
}

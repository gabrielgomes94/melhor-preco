<?php

namespace Src\Products\Application\Services\Composition;

use Src\Products\Infrastructure\Repositories\GetDB;
use Src\Products\Domain\Data\Compositions\Composition;
use Src\Products\Domain\Entities\ProductsCollection;

class GetProducts
{
    private GetDB $repository;

    public function __construct(GetDB $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $compositionProducts): Composition
    {
        foreach ($compositionProducts as $compositionProduct) {
            $products[] = $this->repository->get($compositionProduct);
        }

        $productsCollection = new ProductsCollection($products ?? []);

        return new Composition($productsCollection);
    }
}

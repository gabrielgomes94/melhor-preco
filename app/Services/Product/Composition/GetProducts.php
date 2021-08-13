<?php

namespace App\Services\Product\Composition;

use App\Repositories\Product\GetDB;
use Barrigudinha\Product\Data\Compositions\Composition;
use Barrigudinha\Product\Entities\ProductsCollection;

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

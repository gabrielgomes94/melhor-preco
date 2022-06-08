<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class ShowProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(string $sku): ProductCosts
    {
        if (!$product = $this->repository->get($sku)) {
            throw new ProductNotFoundException($sku);
        }

        $items = collect($product->getPurchaseItemsCosts());
        $items = $items->sortByDesc(
            fn (PurchaseItem $item) => $item->getIssuedAt()
        )->all();

        return new ProductCosts($product, $items);
    }
}

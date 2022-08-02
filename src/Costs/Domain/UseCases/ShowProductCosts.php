<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;

// @todo: talvez mover essa classe para uma camada ded repositórios
class ShowProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ProductNotFoundException
     */
    public function show(string $sku, string $userId): ProductCosts
    {
        if (!$product = $this->repository->get($sku, $userId)) {
            throw new ProductNotFoundException($sku);
        }

        $items = collect($product->getPurchaseItemsCosts());
        $items = $items->sortByDesc(
            fn (PurchaseItem $item) => $item->getIssuedAt()
        )->all();

        return new ProductCosts($product, $items);
    }
}

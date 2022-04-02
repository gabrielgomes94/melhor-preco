<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\PurchaseItem;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class ShowProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(string $sku): array
    {
        if (!$product = $this->repository->get($sku)) {
            throw new ProductNotFoundException();
        }

        $items = $product->itemsCosts;
        $items = $items->sortByDesc(function (PurchaseItem $item) {
            return $item->getIssuedAt();
        });

        return [
            'product' => $product,
            'costs' => $items,
        ];
    }
}

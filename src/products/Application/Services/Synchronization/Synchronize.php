<?php

namespace Src\Products\Application\Services\Synchronization;

use Src\Products\Domain\Product\Models\Product;
use Src\Products\Infrastructure\Repositories\Creator;
use Src\Products\Domain\Product\Events\ProductsSynchronized;
use Src\Products\Application\Services\Update\UpdateProduct;
use Src\Integrations\Bling\Products\Repositories\Repository as BlingRepository;

class Synchronize
{
    private BlingRepository $erpRepository;
    private Creator $creator;
    private UpdateProduct $productUpdator;

    public function __construct(
        BlingRepository $erpRepository,
        Creator $creator,
        UpdateProduct $productUpdator
    ) {
        $this->erpRepository = $erpRepository;
        $this->creator = $creator;
        $this->productUpdator = $productUpdator;
    }

    public function sync(): void
    {
        $products = $this->erpRepository->all();
        $updatedCount = 0;
        $createdCount = 0;

        foreach ($products->data() as $erpProduct) {
            $product = Product::find($erpProduct->sku());
            $data = $erpProduct->toArray();

            if (!$product) {
                $this->creator->createFromArray($data);
                ++$createdCount;

                continue;
            }

            $this->productUpdator->execute($product, $data);
            ++$updatedCount;
        }

        $userId = 1;

        event(new ProductsSynchronized($userId, $createdCount, $updatedCount));
    }
}

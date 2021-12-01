<?php

namespace Src\Products\Application\Services;

use Src\Products\Domain\Events\Product\ProductsSynchronized;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Bling\Repository as BlingRepository;

class SynchronizeProducts
{
    private BlingRepository $erpRepository;

    public function __construct(BlingRepository $erpRepository) {
        $this->erpRepository = $erpRepository;
    }

    public function sync(): void
    {
        $updatedCount = $createdCount = 0;
        $products = $this->erpRepository->all();

        foreach ($products as $erpProduct) {
            $product = Product::find($erpProduct->getSku());

            if (!$product) {
                $erpProduct->save();
                ++$createdCount;

                continue;
            }

            $product->fill($erpProduct->toArray());
            $product->save();
            ++$updatedCount;
        }

        $userId = 1;
        event(new ProductsSynchronized($userId, $createdCount, $updatedCount));
    }
}

<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Events\ProductSynchronized;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeProducts
{
    public function __construct(
        private BlingRepository $erpRepository,
        private ProductRepository $dbRepository
    ) {
    }

    public function sync(User $user): void
    {
        $products = $this->erpRepository->all($user->getErpToken());

        foreach ($products as $erpProduct) {
            $product = $this->dbRepository->get($erpProduct->getSku(), $user->getId());

            if (!$product) {
                $this->dbRepository->save($erpProduct, $user->id);

                continue;
            }

            $product->fill($erpProduct->toArray());
            $this->dbRepository->save($product, $user->id);
        }
    }
}

<?php

namespace Src\Prices\Infrastructure\Laravel\Models;

use Ramsey\Uuid\Uuid;
use Src\Prices\Domain\Events\UnprofitablePrice;
use Src\Products\Domain\Repositories\ProductRepository;

class PriceObserver
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function saved(Price $price)
    {
        if (!$price->isProfitable()) {
            UnprofitablePrice::dispatch($price);
        }
    }

    // @todo: estudar uma forma de implementar melhor essa atribuiçãod e UUIDs e relacionamento com produto
    public function creating(Price $price)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $product = $this->productRepository->get($price->getProductSku(), $userId);

        $price->product_uuid = $product->getUuid();
        $price->uuid = Uuid::uuid4();
    }
}

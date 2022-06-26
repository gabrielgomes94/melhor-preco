<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Products;

use Src\Prices\Domain\UseCases\UpdateDB as UpdateDBInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Services\Prices\UpdatePrice;
use Src\Products\Domain\Models\Post\Contracts\Post;

class UpdateDB implements UpdateDBInterface
{
    private UpdatePrice $updatePrice;

    public function __construct(UpdatePrice $updatePrice)
    {
        $this->updatePrice = $updatePrice;
    }

    public function execute(Post $post): bool
    {
        $priceModel = Price::find($post->getId());

        if (!$priceModel) {
            return false;
        }

        $price = $post->getCalculatedPrice();

        return $this->updatePrice->execute($priceModel, $price);
    }
}

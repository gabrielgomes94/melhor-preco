<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Prices\Price\Application\Services\UpdatePrice;
use Src\Prices\Price\Domain\Models\Price;
use Src\Prices\Price\Domain\Contracts\Services\UpdateDB as UpdateDBInterface;
use Src\Products\Domain\Models\Product\Contracts\Post;

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

        $price = $post->getPrice();

        return $this->updatePrice->execute($priceModel, $price);
    }
}

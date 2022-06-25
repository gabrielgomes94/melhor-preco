<?php

namespace Src\Prices\Application\Services\Products;

use Src\Prices\Application\Services\UpdatePrice;
use Src\Prices\Domain\Models\Price;
use Src\Prices\Domain\Contracts\Services\UpdateDB as UpdateDBInterface;
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

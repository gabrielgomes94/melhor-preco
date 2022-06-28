<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Products\Commands;

use Src\Prices\Domain\UseCases\Products\UpdateDBCommand as UpdateDBInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Repositories\PriceRepository;
use Src\Products\Domain\Models\Post\Contracts\Post;

class UpdateDBCommandCommand implements UpdateDBInterface
{
    public function __construct(private PriceRepository $priceRepository)
    {
    }

    public function execute(Post $post): bool
    {
        $priceModel = Price::find($post->getId());

        if (!$priceModel) {
            return false;
        }

        $price = $post->getCalculatedPrice();

        return $this->priceRepository->updateFromCalculatedPrice($priceModel, $price);
    }
}

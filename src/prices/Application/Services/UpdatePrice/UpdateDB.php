<?php

namespace Src\Prices\Application\Services\UpdatePrice;

use Src\Prices\Infrastructure\Repositories\Price\Repository;
use Src\Prices\Domain\Contracts\Services\UpdatePrice\UpdateDB as UpdateDBInterface;
use Src\Products\Domain\Entities\Post;

class UpdateDB implements UpdateDBInterface
{
    private Repository $priceRepository;

    public function __construct(Repository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    public function execute(Post $post): bool
    {
        if (!$priceModel = $this->priceRepository->get($post->id())) {
            return false;
        }

        return $this->priceRepository->update($priceModel, $post->price(), $post->profit());
    }
}

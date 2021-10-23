<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Prices\Price\Infrastructure\Repositories\Repository;
use Src\Prices\Price\Domain\Contracts\Services\UpdateDB as UpdateDBInterface;
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

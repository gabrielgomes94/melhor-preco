<?php

namespace Src\Prices\Application\Services\UpdatePrice;

use App\Repositories\Pricing\Price\Repository;
use Barrigudinha\Pricing\Services\UpdatePrice\Contracts\UpdateDB as UpdateDBInterface;
use Barrigudinha\Product\Entities\Post;

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

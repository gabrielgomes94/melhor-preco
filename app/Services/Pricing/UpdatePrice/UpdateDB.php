<?php


namespace App\Services\Pricing\UpdatePrice;


use App\Models\Price;
use App\Repositories\Pricing\Price\Repository;
use Barrigudinha\Pricing\Services\UpdatePrice\Contracts\UpdateDB as UpdateDBAlias;
use Barrigudinha\Product\Entities\Post;

class UpdateDB implements UpdateDBAlias
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

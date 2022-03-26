<?php

namespace Src\Promotions\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Domain\Models\Promotion;
use Src\Promotions\Domain\Repositories\Repository as RepositoryInterface;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion as PromotionModel;

class Repository implements RepositoryInterface
{
    public function create(PromotionSetup $data, array $products): Promotion
    {
        $promotion = new PromotionModel();
        $promotion->uuid = Uuid::uuid4();
        $promotion->fill([
            'name' => $data->name,
            'products' => $products,
            'discount' => $data->discount->get(),
            'begin_date' => $data->beginDate,
            'end_date' => $data->endDate,
            'max_products_limit' => $data->productsMaxLimit,
        ]);

        $promotion->save();

        return $promotion->refresh();
    }

    public function list()
    {
        // TODO: Implement list() method.
    }

    public function get(string $uuid): Promotion
    {
        return PromotionModel::where('uuid', $uuid)->get();
    }
}

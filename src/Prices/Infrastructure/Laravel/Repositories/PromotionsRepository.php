<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Ramsey\Uuid\Uuid;
use Src\Prices\Domain\DataTransfer\PromotionSetup;
use Src\Prices\Domain\Models\Promotion;
use Src\Prices\Domain\Repositories\PromotionsRepository as RepositoryInterface;
use Src\Prices\Infrastructure\Laravel\Models\Promotion as PromotionModel;

class PromotionsRepository implements RepositoryInterface
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
            'marketplace_subsidy' => $data->marketplaceSubsidy->get() ?? 0,
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
        return PromotionModel::where('uuid', $uuid)->first();
    }

    public function update(string $uuid, PromotionSetup $data, array $products): Promotion
    {
        $promotion = $this->get($uuid);
        $promotion->fill([
            'name' => $data->name,
            'discount' => $data->discount->get(),
            'begin_date' => $data->beginDate,
            'end_date' => $data->endDate,
            'max_products_limit' => $data->productsMaxLimit,
            'marketplace_subsidy' => $data->marketplaceSubsidy->get() ?? 0,
            'products' => $products,
        ]);
        $promotion->save();

        return $promotion->refresh();
    }
}

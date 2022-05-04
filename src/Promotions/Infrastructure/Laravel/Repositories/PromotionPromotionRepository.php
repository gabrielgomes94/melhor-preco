<?php

namespace Src\Promotions\Infrastructure\Laravel\Repositories;

use Ramsey\Uuid\Uuid;
use Src\Prices\Domain\Models\Price;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;
use Src\Promotions\Domain\Data\Entities\Promotion;
use Src\Promotions\Domain\Repositories\PromotionRepository as RepositoryInterface;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion as PromotionModel;

class PromotionPromotionRepository implements RepositoryInterface
{
    /**
     * @param Price[] $prices
     */
    public function create(PromotionSetup $data, array $prices): Promotion
    {
        $promotion = new PromotionModel();
        $promotion->uuid = Uuid::uuid4();
        $promotion->fill([
            'name' => $data->name,
            'discount' => $data->discount->get(),
            'begin_date' => $data->beginDate,
            'end_date' => $data->endDate,
            'marketplace_subsidy' => $data->marketplaceSubsidy->get() ?? 0,
            'max_products_limit' => $data->productsMaxLimit,
        ]);

        $promotion->save();

        $promotion->prices()->createMany(
            $this->transformPrices($promotion->uuid, $prices)
        );

        return $promotion->refresh();
    }

    private function transformPrices(string $promotionUuid, array $prices): array
    {
        $transformed = collect($prices)->transform(
            fn (Price $price) => [
                'uuid' => Uuid::uuid4(),
                'price_id' => $price->getId(),
                'profit' => $price->getProfit(),
                'promotion_uuid' => $promotionUuid,
                'value' => $price->getValue(),
            ]
        );

        return $transformed->toArray();
    }

    /**
     * @return Promotion[]
     */
    public function list(): array
    {
        return Promotion::all()->all();
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

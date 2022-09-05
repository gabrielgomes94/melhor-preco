<?php

namespace Tests\Data\Models\Prices;

use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Product;

class PriceData
{
    public static function persisted(Product $product, Marketplace $marketplace, array $data = []): Price
    {
        $price = self::build($marketplace, $data);
        $price->product()->associate($product);
        $price->save();

        return $price;
    }

    public static function build(Marketplace $marketplace, array $data = []): Price
    {
        $data = array_merge(self::get(), $data);
        $price = new Price($data);
        $price->marketplace()->associate($marketplace);

        $price->margin = $data['profit'] / $data['value'] * 100;
        $price->uuid = $data['uuid'] ?? Uuid::uuid4();

        return $price;
    }

    private static function get(): array
    {
        return [
            'commission' => 10.0,
            'profit' => 2.0,
            'value' => 10.0,
            'additional_costs' => 0.0,
            'store_sku_id' => '3213123',
        ];
    }
}

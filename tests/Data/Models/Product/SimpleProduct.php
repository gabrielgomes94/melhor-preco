<?php

namespace Tests\Data\Models\Product;

use Src\Prices\Domain\Models\Price;
//use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Models\Product\Product;
use Tests\Data\Models\Product\Contracts\ProductFactory;

class SimpleProduct implements ProductFactory
{
    public static function make(array $overwrite = []): Product
    {
        return self::getProduct(self::getData($overwrite));
    }

    public static function create(array $overwrite = []): Product
    {
        $product = self::make($overwrite);

        $product->save();

        foreach ($product->prices as $price) {
            $product->prices()->save($price);
        }

        return $product;
    }

    private static function getProduct(array $data): Product
    {
        $product = new Product($data);

        foreach ($data['prices'] as $price) {
            $product->prices->add(new Price($price));
        }

        return $product;
    }

    private static function getData(?array $overwrite = []): array
    {
        // To Do: refactor product model in order to remove sku attribute
        if (isset($overwrite['id'])) {
            $overwrite['sku'] = $overwrite['id'];
        }

        return array_merge(Data::baseProduct(), $overwrite);
    }
}

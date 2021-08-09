<?php

namespace App\Factories\Product;

use App\Models\Price;
use Barrigudinha\Product\Entities\Post as ProductPost;
use Barrigudinha\Product\Data\Store;
use Barrigudinha\Utils\Helpers;

class Post
{
    public static function build(array $data): ProductPost
    {
        $store = new Store(store_sku_id: $data['storeSkuId'], code: $data['slug']);
        $price = Helpers::floatToMoney($data['price']);

        $post = new ProductPost(
            id: null,
            price: $price,
            store: $store
        );

        return $post;
    }

    public static function buildFromModel(Price $pricePost): ProductPost
    {
        return new ProductPost(
            id: $pricePost->id,
            price: Helpers::floatToMoney($pricePost->value),
            store: new Store(store_sku_id: $pricePost->store_sku_id, code: $pricePost->store),
            profit: Helpers::floatToMoney($pricePost->profit) ?? null,
        );
    }

    public static function buildFromArray(array $pricePost): ProductPost
    {
        return new ProductPost(
            id: $pricePost['id'] ?? null,
            price: Helpers::floatToMoney($pricePost['price']),
            store: new Store(store_sku_id: $pricePost['storeSkuId'], code: $pricePost['storeSlug']),
            profit: Helpers::floatToMoney($pricePost['profit']) ?? null,
        );
    }
}

<?php

namespace App\Factories\Product;

use Barrigudinha\Product\Post as ProductPost;
use Barrigudinha\Product\Store;
use Barrigudinha\Utils\Helpers;

class Post
{
    public static function buildFromERP(array $data): ProductPost
    {
        $store = new Store(store_sku_id: $data['skuStoreId'], code: $data['code']);
        $price = Helpers::floatToMoney($data['price']);

        $post = new ProductPost(
            id: null,
            price: $price,
            store: $store
        );

        return $post;
    }
}

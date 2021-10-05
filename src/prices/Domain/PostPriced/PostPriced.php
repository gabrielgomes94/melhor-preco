<?php

namespace Src\Prices\Domain\PostPriced;

use Barrigudinha\Product\Entities\Post;
use Barrigudinha\Product\Entities\Product;
use Src\Prices\Domain\Price\Price;

class PostPriced
{
    private Product $product;
    private Post $post;
    private Price $price;

    public function __construct(Post $post, Price $price, Product $product, array $options = [])
    {
        $this->post = $post;
        $this->price = $price;
        $this->product = $product;
    }

    public function post(): Post
    {
        return $this->post;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function product(): Product
    {
        return $this->product;
    }
}

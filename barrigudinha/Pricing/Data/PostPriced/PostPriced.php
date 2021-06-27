<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Product\Post;
use Barrigudinha\Product\Product;

class PostPriced
{
    private Product $product;
    private Post $post;
    private Price $price;

    public function __construct(Post $post, Price $price, Product $product)
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
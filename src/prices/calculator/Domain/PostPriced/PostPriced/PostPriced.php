<?php

namespace Src\Prices\Calculator\Domain\PostPriced;

use Src\Products\Domain\Entities\Post;
use Src\Products\Domain\Entities\Product;
use Src\Prices\Calculator\Domain\Price\Price;

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

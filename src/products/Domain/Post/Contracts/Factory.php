<?php


namespace Src\Products\Domain\Post\Contracts;


use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Post\Post;

interface Factory
{
    public static function make(array $data): Post;

    public static function updatePrice(Post $post, Price $price, array $data): Post;
}

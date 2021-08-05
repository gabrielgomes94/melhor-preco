<?php

namespace App\Presenters\Pricing\Post;

use Barrigudinha\Pricing\Data\PostPriced\MagaluPostPriced;
use Barrigudinha\Pricing\Data\PostPriced\MercadoLivrePostPriced;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;

class Factory
{
    public static function make(PostPriced $postPriced): Post
    {
        if ($postPriced instanceof MagaluPostPriced) {
            return new MagaluPost($postPriced);
        }

        if ($postPriced instanceof MercadoLivrePostPriced) {
            return new MercadoLivrePost($postPriced);
        }

        return new Post($postPriced);
    }
}

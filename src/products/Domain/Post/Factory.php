<?php

namespace Src\Products\Domain\Post;

use Src\Products\Domain\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Store\Factory as StoreFactory;

/**
 * To Do: mover essa classe pra camada de aplicação e fazer o make criar um objeto especializado quando for mercado livre.
 *  Criar interface para Factory e deixar ela na camada de domínio
 *
 * Class Factory
 * @package Src\Products\Domain\Post
 */
class Factory
{
    public static function make(array $data)
    {
        return new Post(
            new PostIdentifiers($data['id'], $data['store_sku_id']),
            StoreFactory::make($data['store']),
            $data['value'],
            $data['profit'],
        );
    }
}

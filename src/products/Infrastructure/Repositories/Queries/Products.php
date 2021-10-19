<?php

namespace Src\Products\Infrastructure\Repositories\Queries;

use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Contracts\Repositories\Query;
use Src\Products\Domain\Contracts\Utils\Options;

/**
 * @TODO: mover esse diretório pro contexto de produtos
 * Class Products
 *
 * @package Src\Prices\Infrastructure\Repositories\Queries
 */
class Products implements Query
{
    public static function count(Options $options): int
    {
        return self::query($options)->count();
    }

    public static function paginate(Options $options): array
    {
        return self::query($options)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();
    }

    /**
     * @inheritDoc
     */
    public static function query(Options $options)
    {
        return Product::whereNull('parent_sku')
            ->where('is_active', true)
            ->orderBy('sku');
    }
}

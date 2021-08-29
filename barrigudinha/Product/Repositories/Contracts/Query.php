<?php

namespace Barrigudinha\Product\Repositories\Contracts;

use Barrigudinha\Product\Utils\Contracts\Options;

interface Query
{
    public static function count(Options $options): int;
    public static function paginate(Options $options): array;

    /**
     * @return mixed
     */
    public static function query(Options $options);
}

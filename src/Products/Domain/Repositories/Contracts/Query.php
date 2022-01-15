<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Src\Products\Domain\Utils\Contracts\Options;

interface Query
{
    public static function count(Options $options): int;
    public static function paginate(Options $options): array;

    /**
     * @return mixed
     */
    public static function query(Options $options);
}

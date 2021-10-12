<?php

namespace Src\Products\Domain\Contracts\Repositories;

use Src\Products\Domain\Contracts\Utils\Options;

interface Query
{
    public static function count(Options $options): int;
    public static function paginate(Options $options): array;

    /**
     * @return mixed
     */
    public static function query(Options $options);
}

<?php

namespace Src\Notifications\Domain\Contracts\Repository;

use App\Options\Contracts\Options as PaginatorOptions;

interface Options extends PaginatorOptions
{
    public function main(): string;

    public function type(): string;
}

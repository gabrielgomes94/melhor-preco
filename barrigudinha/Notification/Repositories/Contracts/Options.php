<?php

namespace Barrigudinha\Notification\Repositories\Contracts;

use Barrigudinha\Utils\Paginator\Contracts\Options as PaginatorOptions;

interface Options extends PaginatorOptions
{
    public function main(): string;

    public function type(): string;
}

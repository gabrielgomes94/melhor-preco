<?php

namespace App\Services\Utils;

use Barrigudinha\Utils\Paginator\Contracts\Options;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    public function paginate(iterable $array, Options $options, int $count): LengthAwarePaginator
    {
        $currentPage = $options->page() ?? 1;
        $perPage = $options->perPage();

        return new LengthAwarePaginator(
            $array,
            $count,
            $perPage,
            $currentPage,
            [
                'path' => $options->url(),
                'query' => $options->query(),
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Utils;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    private const PAGE = 'page';

    public function paginate(array $array, Request $request, int $perPage = 40, int $count = 0): LengthAwarePaginator
    {
        $currentPage = $request->input(self::PAGE) ?? 1;

        return new LengthAwarePaginator(
            $array,
            $count,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}

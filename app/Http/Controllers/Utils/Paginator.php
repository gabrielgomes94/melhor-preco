<?php

namespace App\Http\Controllers\Utils;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    private const PAGE = 'page';

    public function paginate(array $array, Request $request, int $perPage = 40): LengthAwarePaginator
    {
        $currentPage = $request->input(self::PAGE) ?? 1;
        $startingPoint = ($currentPage * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($array, $startingPoint, $perPage, true),
            count($array),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}

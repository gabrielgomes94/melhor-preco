<?php

namespace Src\Integrations\Bling\Categories\Requests;

class Config
{
    public static function listCategoriesOptions(string $apiToken): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => $apiToken,
            ],
        ];
    }

    public static function listCategoriesUrl(int $page): string
    {
        return "categorias/page={$page}/json/";
    }
}

<?php

namespace Src\Integrations\Bling\Categories\Requests;

class Config
{
    public static function listCategoriesOptions(): array
    {
        return [
            'base_uri' => config('integrations.bling.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
            ]
        ];
    }

    public static function listCategoriesUrl(int $page): string
    {
        return "categorias/page={$page}/json/";
    }
}

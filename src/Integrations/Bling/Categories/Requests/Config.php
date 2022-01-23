<?php

namespace Src\Integrations\Bling\Categories\Requests;

class Config
{
    public static function listCategories(): array
    {
        return [
            'base_uri' => config('integrations.bling.categories.list.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
            ]
        ];
    }
}

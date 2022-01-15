<?php

namespace Src\Integrations\Bling\Categories\Requests;

class Config
{
    public static function listProducts()
    {
        return [
            'base_uri' => config('integrations.bling.endpoints.categories.list.base_uri'),
            'query' => [
                'apikey' => config('integrations.bling.auth.apikey'),
            ]
        ];
    }
}

<?php

namespace Src\Integrations\Bling\Categories;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Categories\Requests\Config;
use Src\Integrations\Bling\Categories\Responses\Sanitizer;

class Client
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function list(int $page = 1): array
    {
        $response = Http::withOptions(
            Config::listCategories()
        )->get("page={$page}/json/");

        return $this->sanitizer->sanitize($response);
    }
}

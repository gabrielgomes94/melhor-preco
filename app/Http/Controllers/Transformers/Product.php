<?php
namespace App\Http\Controllers\Transformers;

use App\Bling\Response\ProductResponse;

class Product
{
    public function __construct()
    {

    }

    public function transform(ProductResponse $response): array
    {
        $data = [];

        if ($response->hasErrors()) {
            $data['errors'] = $response->errors();
        }

        if ($response->hasData()) {
            $data['products'] = $response->toArray();
        }

        return $data;
    }
}

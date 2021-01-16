<?php
namespace App\Http\Transformers;

use App\Bling\Product\Response\ProductResponse;

class ProducTransformer
{
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

<?php
namespace App\Http\Transformers;

use App\Bling\Product\Response\ProductResponse;

class ProductTransformer
{
    public function transform(ProductResponse $response): array
    {
        $data = [];

        if ($response->hasErrors()) {
            $data['errors'] = $response->errors();
        }

        if ($response->hasData()) {
            $data['products'] = $response->toArray();
            $data = $this->transformStock($data);
        }

        return $data;
    }

    private function transformStock(array $data): array
    {
        $stock = $data['products'][0]['stock'];

        if (is_null($stock)) {
            $stock = 'Não há registro no estoque.';
        }
        $data['products'][0]['stock'] = $stock;

        return $data;
    }
}

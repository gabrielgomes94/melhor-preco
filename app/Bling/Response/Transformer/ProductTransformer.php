<?php
namespace App\Bling\Response\Transformer;

use App\Bling\Data\Product;

class ProductTransformer
{
    public function transform(array $data)
    {
        $transformedData = [];

        if (isset($data['retorno']['erros'])) {
            $transformedData['errors'] = $this->setErrors($data);
        }

        if (isset($data['retorno']['produtos'])) {
            $transformedData['data'] = $this->setProducts($data);
        }

        return $transformedData;
    }

    private function setErrors($data): array
    {
        $errors = [];
        foreach ($data as $error) {
            $errors[] = $error;
        }

        return $errors;
    }

    private function setProducts(array $data): array
    {
        $products = [
            'products' => []
        ];

        foreach ($data['retorno']['produtos'] as $product) {
            $product = $product['produto'];

            $products['products'][] = [
                'code' => $product['codigo'],
                'name' => $product['descricao'],
                'brand' => $product['marca'],
                'images' => [] ?? null,
                'stock' => $product['estoqueAtual'] ?? null,
            ];
        }

        return $products;
    }
}

<?php

namespace App\Services\Product\StockTag;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use function route;

/**
 * @deprecated
 * TO DO: contextualizar essa classe dentro de app/Services/Product/StockTag/QRCode
 */
class GenerateQRCode
{
    public function generate(array $products)
    {
        $qrCodes = [];

        foreach($products as $product) {
            for($i = 0; $i < $product['stock']; $i++) {
                $productLink = route('product.show', ['sku' => $product['sku']]);
                $productLink = $tempProductLink = 'https://barrigudinha.com/product/' . $product['sku'] . '/stock';

                $qrCodes[] = [
                    'qrCode' => QrCode::generate($productLink),
                    'stock' => $product['stock'],
                    'sku' => $product['sku'],
                ];
            }
        }

        return $qrCodes;
    }
}

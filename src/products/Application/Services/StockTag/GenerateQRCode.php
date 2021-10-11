<?php

namespace Src\Products\Application\Services\StockTag;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function route;

class GenerateQRCode
{
    public function generate(array $products)
    {
        $qrCodes = [];

        foreach ($products as $product) {
            for ($i = 0; $i < $product['stock']; $i++) {
                $productLink = route('products.reports.show', ['sku' => $product['sku']]);

                $qrCodes[] = [
                    'qrCode' => QrCode::generate($productLink),
                    'stock' => $product['stock'],
                    'sku' => $product['sku'],
                    'name' => $product['name'],
                ];
            }
        }

        return $qrCodes;
    }
}

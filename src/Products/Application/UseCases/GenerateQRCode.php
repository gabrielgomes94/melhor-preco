<?php

namespace Src\Products\Application\UseCases;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Src\Products\Domain\UseCases\Contracts\GenerateStockTags;
use function route;

class GenerateQRCode implements GenerateStockTags
{
    public function generate(array $products): array
    {
        $qrCodes = [];

        foreach ($products as $product) {
            for ($i = 0; $i < $product['stock']; $i++) {
                $productLink = route('products.reports.show', ['sku' => $product['sku']]);
                $svg = QrCode::generate($productLink);
                $qrCode = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '"/>';

                $qrCodes[] = [
                    'qrCode' => $qrCode,
                    'stock' => $product['stock'],
                    'sku' => $product['sku'],
                    'name' => $product['name'],
                ];
            }
        }

        return $qrCodes;
    }
}

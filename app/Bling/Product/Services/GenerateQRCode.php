<?php
namespace App\Bling\Product\Services;


use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                    'name' => $product['name'],
                ];
            }
        }

        return $qrCodes;
    }

//    public function generate(array $product)
//    {
//        $qrCodes = [];
//
//        for($i = 0; $i < $product['stock']; $i++) {
//            $productLink = route('product.show', ['sku' => $product['sku']]);
//            $qrCodes[]['qrCode'] = QrCode::generate($productLink);
//            $qrCodes[]['stock'] = $product['stock'];
//            $qrCodes[]['sku'] = $product['sku'];
//        }
//
//        return $qrCodes;
//    }
}

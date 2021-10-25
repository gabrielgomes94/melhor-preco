<?php

namespace Src\Integrations\Bling\Products\Responses\Transformers;

use Src\Integrations\Bling\Products\Responses\Data\Price as PriceData;

class Price
{
    public static function transform(array $data): ?PriceData
    {
        if (!isset($data)) {
            return null;
        }

        $data = self::getData($data);

        return PriceData::createFromArray($data);
    }

    private static function getData(array $product): array
    {
        return [
            'skuStoreId' => $product['idLojaVirtual'],
            'price' => $product['preco']['preco'],
            'promotionalPrice' => $product['preco']['precoPromocional'],
        ];
    }
}

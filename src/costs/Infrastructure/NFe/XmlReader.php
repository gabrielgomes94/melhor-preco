<?php

namespace Src\Costs\Infrastructure\NFe;

use SimpleXMLElement;

class XmlReader
{

    public function getItems(SimpleXMLElement $xml): array|SimpleXMLElement
    {
        $items = json_decode(json_encode((array) $xml->NFe->infNFe), true);

        if ($xml->NFe->infNFe->det->count() === 1) {
            return [$items['det']];
        }

//        dd((array) $xml->NFe->infNFe->det);

        return $items['det'];
    }

    public function hasSingleItem(array $items): bool
    {
        return count($items) === 1;
    }

    public function getProductData(array $items): array
    {
        return $items['prod'] ?? [];
    }

    public function getDiscount(array $product): float
    {
        return $product['vDesc'] ?? 0.0;
    }

    public function getPrice(array $product): float
    {
        return $product['vUnCom'] ?? $product['vUnTrib'] ?? 0.0;
    }

    public function getName(array $product): string
    {
        return $product['xProd'] ?? '';
    }

    public function getQuantity(array $product): float
    {
        return $product['qCom'] ?? $product['qTrib'] ?? 0.0;
    }

    public function getFreightValue($product): float
    {
        return $product['vFrete'] ?? 0.0;
    }

    public function getInsuranceValue($product): float
    {
        return $product['vSeg'] ?? 0.0;
    }

    /**
     * @todo: montar uma estrutura para salvar todos os dados de imposto
     * @todo: salvar os campos de imposto num formato json
     */
    public function getTaxes(array $items): array
    {

        if (empty($items['imposto'])) {
            return [];
        }

        return [
            'totalTaxes' => $items['imposto']['vTotTrib'] ?? 0.0,
            'ipi' => Taxes::getIPI($items['imposto']),
            'icms' => Taxes::getICMS($items['imposto']),
        ];
    }
}

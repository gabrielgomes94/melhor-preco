<?php

namespace Src\Costs\Infrastructure\NFe;

use SimpleXMLElement;
use Src\Costs\Domain\Models\Tax;
use Src\Costs\Domain\Repositories\NFeRepository;

// @todo: rename to NFeXMLRepository
class XmlReader implements NFeRepository
{
    public function getItems(SimpleXMLElement $xml): array
    {
        $items = json_decode(json_encode((array) $xml->NFe->infNFe), true);

        if ($xml->NFe->infNFe->det->count() === 1) {
            return [$items['det']];
        }

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

    public function getEan(array $product): string
    {
        return $product['cEAN'] ?? '';
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
        if ($this->getQuantity($product) === 0) {
            return 0.0;
        }

        $freightValue = (float) ($product['vFrete'] ?? 0.0);

        return $freightValue / $this->getQuantity($product);
    }

    public function getInsuranceValue($product): float
    {
        if ($this->getQuantity($product) === 0) {
            return 0.0;
        }

        $insuranceValue = (float) ($product['vSeg'] ?? 0.0);

        return $insuranceValue  / $this->getQuantity($product);
    }

    public function getTaxes(array $items): array
    {

        if (empty($items['imposto'])) {
            return [];
        }

        return [
            Tax::TOTAL_TAXES => $items['imposto']['vTotTrib'] ?? 0.0,
            Tax::IPI => Taxes::getIPI($items['imposto']),
            TAX::ICMS => Taxes::getICMS($items['imposto']),
            TAX::PIS => Taxes::getPIS($items['imposto']),
            TAX::COFINS => Taxes::getCOFINS($items['imposto'])
        ];
    }
}

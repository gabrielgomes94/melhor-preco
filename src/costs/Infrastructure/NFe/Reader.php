<?php

namespace Src\Costs\Infrastructure\NFe;

class Reader
{
    public function getItems(string $xml): array
    {
        $data = $this->getInvoiceData($xml);

        return $data['NFe']['infNFe']['det'] ?? [];
    }

    public function hasSingleItem(array $items): bool
    {
        return isset($items['@attributes']);
    }

    public function getProductData(array $items): array
    {
        return $items['prod'] ?? [];
    }

    public function getDiscount(array $data): float
    {
        return $data['vDesc'] ?? 0.0;
    }

    public function getPrice(array $data): float
    {
        return $data['vUnCom'] ?? $data['vUnTrib'] ?? 0.0;
    }

    public function getName(array $data): string
    {
        return $data['xProd'] ?? '';
    }

    public function getQuantity(array $data): float
    {
        return $data['qCom'] ?? $data['qTrib'] ?? 0.0;
    }

    public function getFreightValue($data): float
    {
        return $data['vFrete'] ?? 0.0;
    }

    public function getInsuranceValue($data): float
    {
        return $data['vSeg'] ?? 0.0;
    }

    private function getInvoiceData(string $xml): array
    {
        $data = json_encode($xml, true);

        return json_decode($data, true);
    }
}

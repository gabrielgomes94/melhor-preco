<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Costs\Domain\Models\Tax as TaxInterface;
use Src\Costs\Infrastructure\NFe\Mappers\TaxesMapper as TaxesMapper;

class Taxes
{
    private function __construct(
        public readonly Tax $icms,
        public readonly Tax $ipi,
        public readonly Tax $ii,
        public readonly Tax $pis,
        public readonly Tax $cofins,
        public readonly float $totalTaxes
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new static(
            Tax::fromArray(TaxInterface::ICMS, TaxesMapper::getICMS($data)),
            Tax::fromArray(TaxInterface::IPI, TaxesMapper::getIPI($data)),
            Tax::fromArray(TaxInterface::II, []),
            Tax::fromArray(TaxInterface::PIS, TaxesMapper::getPIS($data)),
            Tax::fromArray(TaxInterface::COFINS, TaxesMapper::getCOFINS($data)),
            $data['vTotTrib'] ?? 0.0
        );
    }

    public function toArray(): array
    {
        return [
            TaxInterface::TOTAL_TAXES => $this->totalTaxes,
            TaxInterface::IPI => $this->ipi->toArray(),
            TaxInterface::ICMS => $this->icms->toArray(),
            TaxInterface::PIS => $this->pis->toArray(),
            TaxInterface::COFINS => $this->cofins->toArray()
        ];
    }
}

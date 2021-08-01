<?php

namespace App\Repositories\Product\Options;

class Options
{
    private ?float $minimumProfit;
    private ?float $maximumProfit;
    private bool $kits;

    public function __construct(array $data)
    {
        $this->minimumProfit = (float) $data['minimumProfit'] ?? null;
        $this->maximumProfit = (float) $data['maximumProfit'] ?? null;
        $this->kits = (bool) $data['filterKits'];

    }

    public function hasProfitFilters(): bool
    {
        return $this->maximumProfit || $this->minimumProfit;
    }

    public function maximumProfit(): float
    {
        return $this->maximumProfit ?? 100000000000000000;
    }

    public function minimumProfit(): float
    {
        return $this->minimumProfit ?? -100000000000000000;
    }

    public function filterKits(): bool
    {
        return $this->kits;
    }
}

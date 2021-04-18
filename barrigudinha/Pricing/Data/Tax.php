<?php

namespace Barrigudinha\Pricing\Data;

class Tax
{
    const IPI = 'ipi';
    const ICMS = 'icms';
    const SIMPLES_NACIONAL = 'simples_nacional';

    public float $rate;
    public string $name;
    public string $type;

    private $validNames = [
        self::IPI,
        self::ICMS,
        self::SIMPLES_NACIONAL,
    ];

    private $validTypes = [
        'in',
        'out'
    ];

    public function __construct(string $name, string $type, float $rate)
    {
        $this->name = $name;
        $this->type = $type;
        $this->rate = $rate;
    }
}

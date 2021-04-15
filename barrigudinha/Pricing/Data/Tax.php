<?php

namespace Barrigudinha\Pricing\Data;

class Tax
{
    public float $rate;
    public string $name;
    public string $type;

    private $validNames = [
        'icms',
        'ipi',
        'simples_nacional'
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

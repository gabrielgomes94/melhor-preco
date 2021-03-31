<?php


namespace App\Presenters\Pricing\Data;


use RuntimeException;

class Price
{
    public string $store;
    public float $value;
    public float $profit;

    public function __construct(string $store, float $value, float $profit)
    {
        $this->store = $store;
        $this->value = $value;
        $this->profit = $profit;
    }

    public function toArray(): array
    {
        return [
            'store' => $this->store,
            'value' => $this->value,
            'profit' => $this->profit,
            'profit_margin' => $this->getProfitMargin(),
        ];
    }

    private function getProfitMargin(): float
    {
        if ($this->value <= 0.0) {
            throw new RuntimeException('Valor de venda não pode ser menor ou igual a zero');
        }

        return (float) $this->profit / $this->value;
    }
}

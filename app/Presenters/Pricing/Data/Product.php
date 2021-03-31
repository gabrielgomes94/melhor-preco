<?php


namespace App\Presenters\Pricing\Data;


class Product
{
    public string $sku;

    /**
     * @var Price
     */
    public array $prices;

    public function __construct(string $sku, array $prices)
    {
        $this->sku = $sku;
        $this->prices = $this->setPrices($prices);
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'prices' => array_map(function($price){
                return $price->toArray();
            }, $this->prices),
        ];
    }

    private function setPrices(array $prices): array
    {
        return array_map(function($price){
            return new Price(
                store: $price['store'],
                value: $price['value'],
                profit: $price['profit']
            );
        }, $prices);
    }
}

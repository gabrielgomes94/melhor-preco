<?php


namespace App\Presenters\Pricing\Data;


class Product
{
    public string $id;
    public string $sku;
    public string $name;

    /**
     * @var Price
     */
    public array $prices;

    public function __construct(string $id, string $sku, string $name, array $prices)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->prices = $this->setPrices($prices);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
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

<?php
namespace App\Barrigudinha\Product;

class Product
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string[]
     */
    private $images;

    /**
     * @var ?int
     */
    private $stock;

    public function __construct(array $data)
    {
        $this->fill($data);
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }

    private function fill(array $data): void
    {
        $this->sku = $data['sku'];
        $this->name = $data['name'];
        $this->brand = $data['brand'];
        $this->images = $data['images'] ?? [];
        $this->stock = $data['stock'] ?? null;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function addImages(array $urls)
    {
        foreach($urls as $url) {
            $this->images[] = $url;
        }
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'brand' => $this->brand,
            'images' => $this->images,
            'stock' => $this->stock,
        ];
    }
}

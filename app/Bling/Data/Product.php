<?php
namespace App\Bling\Data;

class Product
{
    /**
     * @var string
     */
    private $code;

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

    private function fill(array $data): void
    {
        $this->code = $data['code'];
        $this->name = $data['name'];
        $this->brand = $data['brand'];
        $this->images = $data['images'] ?? [];
        $this->stock = $data['stock'] ?? null;
    }

    public function getCode(): string
    {
        return $this->code;
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
}

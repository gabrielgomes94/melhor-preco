<?php

namespace Src\Products\Domain\Models\Product\Data;

class Details
{
    private string $name;
    private string $brand;
    private array $images;

    public function __construct(string $name, string $brand, array $images)
    {
        $this->name = $name;
        $this->brand = $brand;
        $this->images = $images;
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
}

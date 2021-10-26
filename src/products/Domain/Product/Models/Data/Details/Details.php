<?php

namespace Src\Products\Domain\Product\Models\Data\Details;

use Src\Products\Domain\Product\Contracts\Models\Data\Details\Details as DetailsInterface;

class Details implements DetailsInterface
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

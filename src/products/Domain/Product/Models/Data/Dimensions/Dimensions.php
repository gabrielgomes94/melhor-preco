<?php

namespace Src\Products\Domain\Product\Models\Data\Dimensions;

use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions as DimensionsInterface;

class Dimensions implements DimensionsInterface
{
    private float $depth;
    private float $height;
    private float $width;
    private float $weight;

    public function __construct(float $depth, float $height, float $width, float $weight)
    {
        $this->fill($depth, $height, $width, $weight);
    }

    public function depth(): float
    {
        return $this->depth;
    }

    public function height(): float
    {
        return $this->height;
    }

    public function weight(): float
    {
        return $this->weight;
    }

    public function width(): float
    {
        return $this->width;
    }

    public function sum(): float
    {
        return $this->depth + $this->height + $this->width;
    }

    public function cubicWeight(): float
    {
        return ($this->depth * $this->height * $this->width)/6000;
    }

    private function fill(float $depth, float $height, float $width, float $weight)
    {
        $this->depth = ($depth > 0) ? $depth : 0.0;
        $this->height = ($height > 0) ? $height : 0.0;
        $this->width = ($width > 0) ? $width : 0.0;
        $this->weight = $weight;
    }
}

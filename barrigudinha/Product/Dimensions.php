<?php

namespace Barrigudinha\Product;

class Dimensions
{
    private float $depth;
    private float $height;
    private float $width;

    public function __construct(float $depth, float $height, float $width)
    {
        $this->fill($depth, $height, $width);
    }

    public function depth(): float
    {
        return $this->depth;
    }

    public function height(): float
    {
        return $this->height;
    }

    public function width(): float
    {
        return $this->width;
    }

    public function sum(): float
    {
        $sum = $this->depth + $this->height + $this->width;
        return $sum;
    }

    private function fill(float $depth, float $height, float $width)
    {
        $this->depth = ($depth > 0) ? $depth : 0.0;
        $this->height = ($height > 0) ? $height : 0.0;
        $this->width = ($width > 0) ? $width : 0.0;
    }
}

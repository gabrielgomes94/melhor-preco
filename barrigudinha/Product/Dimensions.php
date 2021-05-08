<?php


namespace Barrigudinha\Product;


class Dimensions
{
    private float $depth;
    private float $height;
    private float $width;

    public function __construct(float $depth, float $heigth, float $width)
    {
        $this->fill($depth, $heigth, $width);
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

    private function fill(float $depth, float $heigth, float $width)
    {
        $this->depth = ($depth > 0) ? $depth : 0.0;
        $this->height = ($heigth > 0) ? $heigth : 0.0;
        $this->width = ($width > 0) ? $width : 0.0;
    }
}

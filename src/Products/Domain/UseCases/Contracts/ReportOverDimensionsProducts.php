<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface ReportOverDimensionsProducts
{
    public function getOverDimensions(float $depth, float $width, float $height, float $cubicWeight): array;
}

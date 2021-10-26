<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Details;

interface Details
{
    public function getName(): string;

    public function getBrand(): string;

    public function getImages(): array;
}

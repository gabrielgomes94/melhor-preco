<?php

namespace App\Http\Requests\Contracts;

interface HasSKU
{
    public function getSku(): ?string;
}

<?php

namespace Integrations\Bling\Base\Responses;

use Integrations\Bling\Products\Responses\Data\Product as ProductData;

abstract class BaseResponse
{
    protected array $errors = [];

    abstract public function data();

    public function addErrors(string $error)
    {
        $this->errors[] = $error;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}

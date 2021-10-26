<?php

namespace Src\Integrations\Bling\Products\Responses;

use Src\Integrations\Bling\Products\Responses\Contracts\Response as ResponseInterface;
use Src\Integrations\Bling\Products\Responses\Data\Product as ProductData;
use Src\Integrations\Bling\Products\Responses\Data\Product;

abstract class BaseResponse implements ResponseInterface
{
    /**
     * @var Product|Product $data
     */
    protected array|Product $data;
    protected array $errors = [];

    /**
     * @return Product|Product
     */
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

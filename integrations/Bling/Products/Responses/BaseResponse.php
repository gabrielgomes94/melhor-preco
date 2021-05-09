<?php

namespace Integrations\Bling\Products\Responses;

use Integrations\Bling\Products\Responses\Contracts\Response as ResponseInterface;
use Barrigudinha\Product\Product as ProductData;

abstract class BaseResponse implements ResponseInterface
{
    /**
     * @var ProductData[]|ProductData $data
     */
    protected array|ProductData $data;
    protected array $errors = [];

    /**
     * @return ProductData[]|ProductData
     */
    abstract public function data(): array|ProductData;

    public function addErrors(string $error){
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

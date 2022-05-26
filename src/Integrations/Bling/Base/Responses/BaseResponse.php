<?php

namespace Src\Integrations\Bling\Base\Responses;

abstract class BaseResponse
{
    protected array $errors = [];

    abstract public function data();

    public function isEmpty(): bool
    {
        return empty($this->data());
    }

    public function addErrors(string $error)
    {
        $this->errors[] = $error;
    }

    // @todo: criar um método getError(): string
    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}

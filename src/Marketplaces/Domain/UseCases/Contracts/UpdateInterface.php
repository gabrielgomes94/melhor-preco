<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface UpdateInterface
{
    public function update(array $data): bool;
}

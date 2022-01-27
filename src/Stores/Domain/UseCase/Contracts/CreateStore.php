<?php

namespace Src\Stores\Domain\UseCase\Contracts;

interface CreateStore
{
    public function create(array $data): bool;
}

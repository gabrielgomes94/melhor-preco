<?php

namespace Src\Users\Domain\UseCases;

interface RegisterUser
{
    public function create(array $data): bool;
}

<?php

namespace Src\Sales\Domain\Repositories;

interface ErpRepository
{
    public function list(string $erpToken): array;
}

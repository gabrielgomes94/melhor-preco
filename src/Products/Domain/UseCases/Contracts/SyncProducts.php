<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface SyncProducts
{
    public function sync(string $userId): void;
}

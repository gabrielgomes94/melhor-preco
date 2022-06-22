<?php

namespace Src\Products\Domain\UseCases\Contracts;

interface SyncCategories
{
    public function sync(string $userId): void;
}

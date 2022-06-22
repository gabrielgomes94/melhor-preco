<?php

namespace Src\Products\Domain\UseCases\Contracts;

use Src\Users\Infrastructure\Laravel\Models\User;

interface SyncCategories
{
    public function sync(User $user): void;
}

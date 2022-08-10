<?php

namespace Src\Products\Domain\Services;

use Src\Users\Domain\Models\User;

interface SyncProductCosts
{
    public function sync(User $user): void;
}

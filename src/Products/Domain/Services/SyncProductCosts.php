<?php

namespace Src\Products\Domain\Services;

use Src\Users\Domain\Entities\User;

interface SyncProductCosts
{
    public function sync(User $user): void;
}

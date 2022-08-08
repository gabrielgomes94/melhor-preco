<?php

namespace Src\Products\Domain\Services;

use Src\Users\Domain\Entities\User;

interface SyncProducts
{
    public function sync(User $user): void;
}

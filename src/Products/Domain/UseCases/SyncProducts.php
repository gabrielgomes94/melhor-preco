<?php

namespace Src\Products\Domain\UseCases;

use Src\Users\Domain\Entities\User;

interface SyncProducts
{
    public function sync(User $user): void;
}

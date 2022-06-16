<?php

namespace Src\Users\Domain\Repositories;

use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Entities\User;

interface Repository
{
    public function find(string $id): User;

    public function register(array $data): User;

    public function updateErp(User $user, Erp $erp): bool;

    public function updateProfile(User $user, array $data): bool;
}

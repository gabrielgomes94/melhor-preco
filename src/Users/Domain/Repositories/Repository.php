<?php

namespace Src\Users\Domain\Repositories;

use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Models\User;

interface Repository
{
    public function find(string $id): User;

    public function register(array $data): User;

    public function updateErp(User $user, Erp $erp): bool;

    public function updatePassword(User $user, string $currentPassword, string $password): bool;

    public function updateProfile(User $user, string $name, string $phone, string $fiscalId): bool;
}

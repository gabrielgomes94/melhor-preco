<?php

namespace Src\Users\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Entities\User;
use Src\Users\Domain\Repositories\Repository as RepositoryInterface;
use Src\Users\Infrastructure\Laravel\Models\User as UserModel;

class Repository implements RepositoryInterface
{
    public function find(string $id): User
    {
        return UserModel::find($id);
    }

    public function register(array $data): User
    {
        return UserModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'fiscal_id' => $data['fiscal_id'],
        ]);
    }

    public function updateErp(User $user, Erp $erp): bool
    {
        $user->erp = $erp->name;
        $user->erp_token = $erp->token;

        return $user->save();
    }

    public function updateTax(User $user, float $taxRate): bool
    {
        $user->tax_rate = $taxRate;

        return $user->save();
    }
}
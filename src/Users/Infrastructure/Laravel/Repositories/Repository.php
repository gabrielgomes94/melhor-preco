<?php

namespace Src\Users\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Facades\Hash;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Entities\User;
use Src\Users\Domain\Repositories\Repository as RepositoryInterface;
use Src\Users\Domain\ValueObjects\Taxes;
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
        $user->setErp($erp);

        return $user->save();
    }

    public function updateTax(User $user, Taxes $taxes): bool
    {
        $user->setTaxes($taxes);

        return $user->save();
    }

    public function updateProfile(User $user, string $name, string $phone, string $fiscalId): bool
    {
        $user->setProfile($name, $phone, $fiscalId);

        return $user->save();
    }

    public function updatePassword(User $user, string $currentPassword, string $password): bool
    {
        if (!Hash::check($currentPassword, $user->getPassword())) {
            return false;
        }

        $user->setPassword(Hash::make($password));

        return $user->save();
    }
}

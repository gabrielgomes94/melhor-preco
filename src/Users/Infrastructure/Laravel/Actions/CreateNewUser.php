<?php

namespace Src\Users\Infrastructure\Laravel\Actions;

use Src\Users\Infrastructure\Laravel\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Src\Users\Infrastructure\Laravel\Rules\FiscalId;
use Src\Users\Infrastructure\Laravel\Rules\Phone;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        $input['phone'] = $this->formatPhone($input['phone'] ?? '');
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'fiscal_id' => ['required', new FiscalId()],
            'phone' => ['required', new Phone()],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'fiscal_id' => $this->removeNonDigits($input['fiscal_id']),
        ]);
    }

    private function formatPhone(string $phone): string
    {
        return '+55' . $this->removeNonDigits($phone);
    }

    private function removeNonDigits(string $data): string
    {
        return preg_replace('/[^0-9]/', '', $data);
    }
}

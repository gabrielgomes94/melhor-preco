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
        ]);
    }

    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        return '+55' . $phone;
    }
}

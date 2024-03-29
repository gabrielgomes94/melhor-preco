<?php

namespace Src\Users\Infrastructure\Laravel\Actions;

use Src\Users\Infrastructure\Laravel\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;
use Src\Users\Infrastructure\Laravel\Rules\FiscalId;
use Src\Users\Infrastructure\Laravel\Rules\Phone;

class CreateNewUser implements CreatesNewUsers
{
    public function __construct(
        private Repository $repository
    ) {}

    public function create(array $input): User
    {
        $input['phone'] = $this->formatPhone($input['phone'] ?? '');
        $input['fiscal_id'] = $this->removeNonDigits($input['fiscal_id']);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'fiscal_id' => ['required', new FiscalId()],
            'phone' => ['required', new Phone()],
        ])->validate();

        return $this->repository->register($input);
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

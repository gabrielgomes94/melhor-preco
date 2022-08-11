<?php

namespace Tests\Data\Models\Users;

use Src\Math\Percentage;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Models\ValueObjects\Taxes;
use Src\Users\Infrastructure\Laravel\Models\User;
use Illuminate\Support\Str;

class UserData
{
    public static function make(array $data = []): User
    {
        $data = array_merge([
            'name' => 'Artigos de Venda SA',
            'email' => 'usuario@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => '+5511987654321',
            'fiscal_id' => '66569343076',
            'taxes' => new Taxes(
                Percentage::fromPercentage(5.45),
                Percentage::fromPercentage(18),
            ),
        ], $data);

        $user = new User($data);
        $user->setErp(new Erp('token', 'bling'));

        if (isset($data['id'])) {
            $user->id = $data['id'];
        }

        $user->save();

        return $user;
    }
}

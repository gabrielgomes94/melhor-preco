<?php

namespace Tests\Data\Models\Users;

use App\Models\User;
use Illuminate\Support\Str;

class UserData
{
    public static function make(): User
    {
        $user = new User([
            'name' => 'Artigos de Venda SA',
            'email' => 'usuario@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $user->save();

        return $user;
    }
}
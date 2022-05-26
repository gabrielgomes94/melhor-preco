<?php

namespace Tests\Data\Models\Users;

use App\Models\User;

class UserData
{
    public static function make(): User
    {
        return User::factory()->create();
    }
}

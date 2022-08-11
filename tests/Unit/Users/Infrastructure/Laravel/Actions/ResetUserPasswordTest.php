<?php

namespace Src\Users\Infrastructure\Laravel\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_reset_user_password(): void
    {
        // Arrange
        $user = UserData::make();
        $resetUserPassword = new ResetUserPassword();

        // Act
        $resetUserPassword->reset($user, [
            'password' => 'mde42aool',
            'password_confirmation' => 'mde42aool',
        ]);

        // Assert
        $user = $user->refresh();
        $this->assertTrue(Hash::check('mde42aool', $user->getPassword()));
    }
}

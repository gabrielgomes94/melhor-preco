<?php

namespace Src\Users\Infrastructure\Laravel\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_find_user(): void
    {
        // Arrange
        $repository = new Repository();
        UserData::make(['id' => '1234']);

        // Act
        $result = $repository->find('1234');

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    public function test_should_not_find_user(): void
    {
        // Arrange
        $repository = new Repository();

        // Act
        $result = $repository->find('1234');

        // Assert
        $this->assertNull($result);
    }

    public function test_should_register_user(): void
    {
        // Arrange
        $repository = new Repository();
        $input = [
            'name' => 'Tabacaria Ouro Verde',
            'email' => 'ouroverde@tabaco.com',
            'password' => 'senha-segura',
            'phone' => '+5511987654321',
            'fiscal_id' => '31580841040',
        ];

        // Act
        $result = $repository->register($input);

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    public function test_should_update_erp(): void
    {
        // Arrange
        $repository = new Repository();
        $user = UserData::make(['id' => '1234']);

        // Act
        $result = $repository->updateErp($user, new Erp('tray-token', 'tray'));

        // Assert
        $this->assertTrue($result);

        $user = $user->refresh();
        $this->assertSame('tray', $user->getErp());
        $this->assertSame('tray-token', $user->getErpToken());
    }

    public function test_should_update_tax(): void
    {
        // Arrange
        $repository = new Repository();
        $user = UserData::make(['id' => '1234']);

        // Act
        $result = $repository->updateErp($user, new Erp('tray-token', 'tray'));

        // Assert
        $this->assertTrue($result);

        $user = $user->refresh();
        $this->assertSame('tray', $user->getErp());
        $this->assertSame('tray-token', $user->getErpToken());
    }

    public function test_should_update_profile(): void
    {
        // Arrange
        $repository = new Repository();
        $user = UserData::make(['id' => '1234']);

        // Act
        $result = $repository->updateProfile(
            $user,
            'Tacabaria',
            '+55219876543241',
            '07296802000130'
        );

        // Assert
        $this->assertTrue($result);

        $user = $user->refresh();
        $this->assertSame('Tacabaria', $user->getName());
        $this->assertSame('+55219876543241', $user->getPhone());
        $this->assertSame('07296802000130', $user->getFiscalId());
    }

    public function test_should_update_password(): void
    {
        // Arrange
        $repository = new Repository();
        $user = UserData::make(['id' => '1234']);

        // Act
        $result = $repository->updatePassword(
            $user,
            'password',
            '+safe-password',
        );

        // Assert
        $this->assertTrue($result);

        $user = $user->refresh();
        $this->assertTrue(Hash::check('+safe-password', $user->getPassword()));
    }
}

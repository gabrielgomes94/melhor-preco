<?php

namespace Src\Users\Infrastructure\Laravel\Actions;

use Illuminate\Validation\ValidationException;
use Mockery;
use Src\Users\Infrastructure\Laravel\Models\User;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    public function test_should_create_new_user()
    {
        // Arrange
        $repository = Mockery::mock(Repository::class);
        $createNewUser = new CreateNewUser($repository);

        $input = [
            'fiscal_id' => '843.055.550-18',
            'phone' => '(11) 9 8723-1234',
            'name' => 'João da Silva',
            'email' => 'joao@gmail.com',
            'password' => 'qwere4321',
            'password_confirmation' => 'qwere4321',
        ];

        $transformedInput = [
            'fiscal_id' => '84305555018',
            'phone' => '+5511987231234',
            'name' => 'João da Silva',
            'email' => 'joao@gmail.com',
            'password' => 'qwere4321',
            'password_confirmation' => 'qwere4321',
        ];

        // Expects
        $repository->expects()
            ->register($transformedInput)
            ->andReturn(Mockery::mock(User::class));

        // Act
        $result = $createNewUser->create($input);

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * @dataProvider getScenarios
     */
    public function test_should_not_create_new_user_when_data_is_invalid(array $input)
    {
        // Arrange

        $repository = Mockery::mock(Repository::class);
        $createNewUser = new CreateNewUser($repository);

        // Expects
        $this->expectException(ValidationException::class);

        // Act
        $result = $createNewUser->create($input);

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    public function getScenarios(): array
    {
        return [
            'when given invalid email' => [
                'input' => [
                    'fiscal_id' => '843.055.550-18',
                    'phone' => '(11) 9 8723-1234',
                    'name' => 'João da Silva',
                    'email' => 'joao@gmail.com@invalid.com',
                    'password' => 'qwere4321',
                    'password_confirmation' => 'qwere4321',
                ]
            ],
            'when given invalid name' => [
                'input' => [
                    'fiscal_id' => '843.055.550-18',
                    'phone' => '(11) 9 8723-1234',
                    'name' => 'João da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da SilvaJoão da Silva',
                    'email' => 'joao@gmail.com@invalid.com',
                    'password' => 'qwere4321',
                    'password_confirmation' => 'qwere4321',
                ]
            ],
            'when given invalid password' => [
                'input' => [
                    'fiscal_id' => '843.055.550-18',
                    'phone' => '(11) 9 8723-1234',
                    'name' => 'João da Silva',
                    'email' => 'joao@gmail.com@invalid.com',
                    'password' => '4321',
                    'password_confirmation' => '4321',
                ]
            ],
            'when given invalid fiscalId' => [
                'input' => [
                    'fiscal_id' => '123456789098',
                    'phone' => '(11) 9 8723-1234',
                    'name' => 'João da Silva',
                    'email' => 'joao@gmail.com@invalid.com',
                    'password' => 'qwere4321',
                    'password_confirmation' => 'qwere4321',
                ]
            ],
            'when given invalid phone' => [
                'input' => [
                    'fiscal_id' => '843.055.550-18',
                    'phone' => '015 (11) 9 8723-1234',
                    'name' => 'João da Silva',
                    'email' => 'joao@gmail.com@invalid.com',
                    'password' => 'qwere4321',
                    'password_confirmation' => 'qwere4321',
                ]
            ],
        ];
    }
}

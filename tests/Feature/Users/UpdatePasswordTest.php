<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function test_should_update_password(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_update_password();

        $this->then_the_user_password_must_be_updated();
        $this->and_then_session_must_have_a_successful_message();
    }

    public function test_should_not_update_password_when_current_password_does_not_match_user_password(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_update_password_given_a_current_password_that_does_not_match();

        $this->then_the_user_password_must_not_be_updated();
        $this->and_then_session_must_have_an_error_message();
    }

    private function given_i_have_an_user(): void
    {
        $user = UserData::persisted();
        $user->password = Hash::make('password-321');
        $user->save();

        $this->user = $user;
    }

    private function when_i_update_password(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/configuracoes/atualizar-senha', [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
                'current_password' => 'password-321',
            ]);
    }

    private function when_i_update_password_given_a_current_password_that_does_not_match(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/configuracoes/atualizar-senha', [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
                'current_password' => 'new-password',
            ]);
    }

    private function then_the_user_password_must_be_updated(): void
    {
        $this->assertTrue(Hash::check('new-password', $this->user->password));
    }

    private function and_then_session_must_have_a_successful_message(): void
    {
        $this->response->assertSessionHas('message');
    }

    private function then_the_user_password_must_not_be_updated(): void
    {
        $this->assertFalse(Hash::check('new-password', $this->user->password));
    }

    private function and_then_session_must_have_an_error_message(): void
    {
        $this->response->assertSessionHas('error');
    }
}

<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_should_render_registration_form(): void
    {
        $this->when_i_want_to_open_registration_form();

        $this->then_i_must_see_registration_form();
    }

    public function test_should_register_new_user(): void
    {
        $this->when_i_want_to_register_user();

        $this->then_it_must_be_register_in_database();
        $this->and_then_the_user_must_be_redirected();
    }

    public function test_should_register_new_company_user(): void
    {
        $this->when_i_want_to_register_company_user();

        $this->then_the_company_must_be_register_in_database();
        $this->and_then_the_user_must_be_redirected();
    }

    public function test_should_not_register_user_when_input_is_not_valid(): void
    {
        $this->when_i_want_to_register_user_with_invalid_inputs();

        $this->then_the_user_must_not_be_registered_in_database();
        $this->and_then_the_user_must_be_redirected_to_registration_with_errors();
    }

    private function when_i_want_to_register_user(): void
    {
        $this->response = $this->post('/register',
            [
                'fiscal_id' => '843.055.550-18',
                'phone' => '(11) 9 8723-1234',
                'name' => 'João da Silva',
                'email' => 'joao@gmail.com',
                'password' => 'qwere4321',
                'password_confirmation' => 'qwere4321',
            ]
        );
    }

    private function when_i_want_to_register_company_user(): void
    {
        $this->response = $this->post('/register',
            [
                'fiscal_id' => '95.635.116/0001-03',
                'phone' => '(11) 9 8723-1234',
                'name' => 'Companhia de Sapatos',
                'email' => 'sapatos@gmail.com',
                'password' => 'qwere4321',
                'password_confirmation' => 'qwere4321',
            ]
        );
    }

    private function then_it_must_be_register_in_database(): void
    {
        $user = User::first('email',  'joao@gmail.com');

        $this->assertInstanceOf(User::class, $user);
    }

    private function then_the_company_must_be_register_in_database()
    {
        $user = User::first('email',  'sapatos@gmail.com');

        $this->assertInstanceOf(User::class, $user);
    }

    private function and_then_the_user_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }

    private function when_i_want_to_register_user_with_invalid_inputs(): void
    {
        $this->response = $this->post('/register',
            [
                'fiscal_id' => '12313195.635.116/0001-03',
                'phone' => '123 (11) 9 8723-1234',
                'name' => '',
                'email' => 'sapatosgmail.com',
                'password' => '4321',
                'password_confirmation' => 'q21',
            ]
        );
    }

    private function then_the_user_must_not_be_registered_in_database(): void
    {
        $user = User::first('email',  'sapatosgmail.com');

        $this->assertNull($user);
    }

    private function and_then_the_user_must_be_redirected_to_registration_with_errors(): void
    {
        $this->response->assertSessionHasErrors();
    }

    private function when_i_want_to_open_registration_form(): void
    {
        $this->response = $this->get('/register');
    }

    private function then_i_must_see_registration_form(): void
    {
        $this->response->assertViewIs('pages.users.auth.register');
    }
}

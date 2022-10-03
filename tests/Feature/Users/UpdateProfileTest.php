<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function test_should_render_update_profile_page(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_want_to_update_profile();

        $this->then_i_must_see_update_profile_page();
    }

    public function test_should_update_profile(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_update_profile();

        $this->then_the_user_must_be_updated();
        $this->and_then_the_user_must_be_redirected();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::persisted();
    }

    private function when_i_want_to_update_profile(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/configuracoes/perfil');
    }

    private function when_i_update_profile(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/configuracoes/perfil', [
                'name' => 'Importadora SA',
                'fiscal_id' => '32.569.429/0001-90',
                'phone' => '(21) 998785214'
            ]);
    }

    private function then_i_must_see_update_profile_page(): void
    {
        $this->response->assertViewIs('pages.users.profile');
        $this->response->assertViewHas('name', 'Artigos de Venda SA');
        $this->response->assertViewHas('fiscalId', '66569343076');
        $this->response->assertViewHas('phone', '11987654321');
    }

    private function then_the_user_must_be_updated(): void
    {
        $user = $this->user->refresh();

        $this->assertSame('Importadora SA', $user->getName());
        $this->assertSame('32569429000190', $user->getFiscalId());
        $this->assertSame('+5521998785214', $user->getPhone());
    }

    private function and_then_the_user_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }
}

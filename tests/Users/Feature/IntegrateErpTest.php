<?php

namespace Tests\Users\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class IntegrateErpTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function test_should_render_update_erp_form(): void
    {
        $this->given_i_have_a_user_which_does_not_have_an_erp_integrated();

        $this->when_i_want_to_update_erp();

        $this->then_i_must_see_update_erp_page();
    }

    public function test_should_update_erp(): void
    {
        $this->given_i_have_a_user_which_does_not_have_an_erp_integrated();

        $this->when_i_update_erp();

        $this->then_the_user_must_have_an_erp_integrated();
        $this->and_the_user_must_be_redirected();
    }

    private function given_i_have_a_user_which_does_not_have_an_erp_integrated(): void
    {
        $user = UserData::make();
        $user->erp = null;
        $user->erp_token = null;
        $user->save();

        $this->user = $user;
    }

    private function when_i_update_erp(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/configuracoes/integracoes', [
                'erp' => 'Bling',
                'erp_token' => 'any-erp-token'
            ]);
    }

    private function when_i_want_to_update_erp(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/configuracoes/integracoes');
    }

    private function then_the_user_must_have_an_erp_integrated(): void
    {
        $user = $this->user->refresh();

        $this->assertSame('bling', $user->getErp());
        $this->assertSame('any-erp-token', $user->getErpToken());
    }

    private function and_the_user_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }

    private function then_i_must_see_update_erp_page(): void
    {
        $this->response->assertViewIs('pages.users.integrations');
        $this->response->assertViewHas('erpToken', null);
    }
}

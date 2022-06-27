<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UpdateTaxTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function test_should_render_update_tax_form(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_want_to_update_tax();

        $this->then_i_must_see_update_tax_page();
    }

    public function test_should_update_tax(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_update_taxes();

        $this->then_the_user_must_have_its_taxes_updated();
        $this->and_the_user_must_be_redirected();
    }

    private function given_i_have_an_user(): void
    {
        $user = UserData::make();
        $user->tax_rate = 2.0;
        $user->save();

        $this->user = $user;
    }

    private function when_i_want_to_update_tax(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/configuracoes/impostos');
    }

    private function when_i_update_taxes()
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/configuracoes/impostos', [
                'tax_rate' => 4.65,
            ]);
    }

    private function then_i_must_see_update_tax_page(): void
    {
        $this->response->assertViewIs('pages.users.taxes');
        $this->response->assertViewHas('taxRate', 2.0);
    }

    private function then_the_user_must_have_its_taxes_updated()
    {
        $this->user = $this->user->refresh();

        $this->assertSame(4.65, $this->user->getSimplesNacionalTaxRate());
    }

    private function and_the_user_must_be_redirected()
    {
        $this->response->assertRedirect();
    }
}

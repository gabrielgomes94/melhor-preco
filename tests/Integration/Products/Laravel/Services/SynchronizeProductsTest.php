<?php

namespace Tests\Integration\Products\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\TestCase;

class SynchronizeProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_should_synchronize_new_products(): void
    {
        $this->given_i_have_an_user_with_no_products();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_products();

        $this->then_i_must_have_in_database_the_products_downloaded_from_bling();
    }

    public function test_should_synchronize_old_products(): void
    {
        $this->given_i_have_an_user_with_products();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_products();

        $this->then_i_must_have_in_database_the_products_updated_from_bling();
    }
}

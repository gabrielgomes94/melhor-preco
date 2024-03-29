<?php

namespace Tests\Feature\Users\Concerns;

use Tests\Data\Models\Users\UserData;

trait UsersDatabase
{
    private function given_i_am_an_user(): void
    {
        $this->user = UserData::persisted();
    }

    private function given_i_am_a_logged_user(): void
    {
        $this->user = UserData::persisted();
        $this->actingAs($this->user);
    }
}

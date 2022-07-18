<?php

namespace Tests\Feature;

use Tests\Data\Models\Users\UserData;

// @todo: verificar onde essa trait pode ficar
trait SimpleUser
{
    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
    }

}

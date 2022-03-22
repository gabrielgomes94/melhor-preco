<?php

namespace Src\Promotions\Domain\Repositories;

use Src\Promotions\Domain\Models\Promotion;

interface Repository
{
    public function create(array $data): Promotion;

    public function list();

    public function get(): Promotion;
}

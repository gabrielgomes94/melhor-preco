<?php

namespace Src\Promotions\Domain\Repositories;

use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Domain\Models\Promotion;

interface Repository
{
    public function create(PromotionSetup $data, array $products): Promotion;

    public function list();

    public function get(string $uuid): Promotion;
}

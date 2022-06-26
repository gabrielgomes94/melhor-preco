<?php

namespace Src\Prices\Domain\Repositories;

use Src\Prices\Domain\DataTransfer\PromotionSetup;
use Src\Prices\Domain\Models\Promotion;

interface PromotionsRepository
{
    public function create(PromotionSetup $data, array $products): Promotion;

    public function list();

    public function get(string $uuid): Promotion;

    public function update(string $uuid, PromotionSetup $data, array $products): Promotion;
}

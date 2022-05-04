<?php

namespace Src\Promotions\Domain\Repositories;

use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;
use Src\Promotions\Domain\Data\Entities\Promotion;

interface PromotionRepository
{
    public function create(PromotionSetup $data, array $products): Promotion;

    /**
     * @return Promotion[]
     */
    public function list(): array;

    public function get(string $uuid): Promotion;

    public function update(string $uuid, PromotionSetup $data, array $products): Promotion;
}

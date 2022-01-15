<?php


namespace Src\Products\Domain\Models\Post\Contracts;


interface Store
{
    public function getSkuId(): string;

    public function getSlug(): string;

    public function getName(): string;

    public function getErpCode(): string;
}

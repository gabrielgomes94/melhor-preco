<?php

namespace Src\Products\Domain\Repositories\Contracts\Erp;

interface ProductRepository
{
    public function all();

    public function allOnStore(string $store);

    public function get(string $sku);

    public function uploadImages(string $sku, string $path, array $images);
}

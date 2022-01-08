<?php

namespace Src\Costs\Domain\Repositories;

use SimpleXMLElement;

interface NFeRepository
{
    public function getItems(SimpleXMLElement $xml): array;

    public function hasSingleItem(array $items): bool;

    public function getProductData(array $items): array;

    public function getDiscount(array $product): float;

    public function getEan(array $product): string;

    public function getPrice(array $product): float;

    public function getName(array $product): string;

    public function getQuantity(array $product): float;

    public function getFreightValue($product): float;

    public function getInsuranceValue($product): float;

    public function getTaxes(array $items): array;
}

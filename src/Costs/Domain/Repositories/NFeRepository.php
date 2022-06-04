<?php

namespace Src\Costs\Domain\Repositories;

use SimpleXMLElement;

interface NFeRepository
{
    public function getPurchaseItems(SimpleXMLElement $xml);
}

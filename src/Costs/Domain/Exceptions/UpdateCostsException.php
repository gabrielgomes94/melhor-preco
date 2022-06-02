<?php

namespace Src\Costs\Domain\Exceptions;

class UpdateCostsException extends \Exception
{
    public function __construct(string $productId)
    {
        parent::__construct("Os custos do produto {$productId} não puderam ser atualizados.");
    }
}

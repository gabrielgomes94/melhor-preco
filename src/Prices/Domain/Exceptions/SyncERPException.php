<?php

namespace Src\Prices\Domain\Exceptions;

use Src\Prices\Domain\Exceptions\UpdatePriceException;

class SyncERPException extends UpdatePriceException
{
    protected $message = 'Preço não foi sincronizado no Bling';
}

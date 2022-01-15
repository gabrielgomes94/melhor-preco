<?php

namespace Src\Prices\Application\Services\Exceptions;

use Src\Prices\Application\Services\Exceptions\UpdatePriceException;

class SyncERPException extends UpdatePriceException
{
    protected $message = 'Preço não foi sincronizado no Bling';
}

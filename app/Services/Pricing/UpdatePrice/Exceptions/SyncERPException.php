<?php

namespace App\Services\Pricing\UpdatePrice\Exceptions;

class SyncERPException extends UpdatePriceException
{
    protected $message = 'Preço não foi sincronizado no Bling';
}

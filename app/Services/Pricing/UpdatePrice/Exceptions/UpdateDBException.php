<?php

namespace App\Services\Pricing\UpdatePrice\Exceptions;

class UpdateDBException extends UpdatePriceException
{
    protected $message = 'Preço não foi atualizado no banco de dados.';
}

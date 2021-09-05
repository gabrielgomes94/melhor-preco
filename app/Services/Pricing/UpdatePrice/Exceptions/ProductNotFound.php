<?php

namespace App\Services\Pricing\UpdatePrice\Exceptions;

class ProductNotFound extends UpdatePriceException
{
    protected $message = 'Produto não foi encontrado no banco de dados.';
}

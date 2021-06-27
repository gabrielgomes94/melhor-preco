<?php

namespace App\Exceptions\Store;

use Exception;

class InvalidStoreException extends Exception
{
    public function __construct($store)
    {
        $message = 'Store ' . $store . ' is invalid.';

        parent::__construct($message);
    }
}

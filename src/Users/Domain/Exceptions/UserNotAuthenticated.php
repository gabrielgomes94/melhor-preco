<?php

namespace Src\Users\Domain\Exceptions;

use Exception;

class UserNotAuthenticated extends Exception
{
    protected $message = 'User not authenticated.';
}

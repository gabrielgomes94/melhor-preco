<?php

namespace Src\Notifications\Application\Exceptions;

use Exception;

class NotificationNotFoundException extends Exception
{
    protected $message = 'Notificação não foi encontrada';
}

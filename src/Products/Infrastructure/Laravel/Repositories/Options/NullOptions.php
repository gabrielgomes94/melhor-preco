<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Options;

class NullOptions extends Options
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}

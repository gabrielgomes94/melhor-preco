<?php

namespace Src\Products\Infrastructure\Repositories\Options;

class NullOptions extends Options
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}

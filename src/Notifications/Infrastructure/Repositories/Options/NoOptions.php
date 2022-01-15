<?php

namespace Src\Notifications\Infrastructure\Repositories\Options;

class NoOptions extends Options
{
    public function __construct(array $data = [])
    {
        $this->page = 1;
        $this->path = '';
        $this->query = [];
        $this->main = '';
        $this->type = '';

        $this->filter = '';
        $this->onlySolved = false;
    }
}

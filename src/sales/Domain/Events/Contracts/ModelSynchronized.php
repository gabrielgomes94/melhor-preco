<?php

namespace Src\Sales\Domain\Events\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ModelSynchronized
{
    public function getModel(): Model;
}

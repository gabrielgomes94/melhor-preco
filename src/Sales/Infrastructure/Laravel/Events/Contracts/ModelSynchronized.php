<?php

namespace Src\Sales\Infrastructure\Laravel\Events\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ModelSynchronized
{
    public function getModel(): ?Model;
}

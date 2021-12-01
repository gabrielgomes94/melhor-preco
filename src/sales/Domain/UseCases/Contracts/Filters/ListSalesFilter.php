<?php

namespace Src\Sales\Domain\UseCases\Contracts\Filters;

use Carbon\Carbon;

interface ListSalesFilter
{
    public function getBeginDate(): Carbon;

    public function getEndDate(): Carbon;

    public function getPage(): int;
}

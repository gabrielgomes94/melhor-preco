<?php

namespace Src\Sales\Application\UseCases\Filters;

use Carbon\Carbon;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter as ListSalesFilterInterface;

class ListSalesFilter implements ListSalesFilterInterface
{
    private const DATE_FORMAT = 'd/m/Y';

    private Carbon $beginDate;
    private Carbon $endDate;
    private int $page;

    public function __construct(array $options = [])
    {
        $this->beginDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['beginDate']);
        $this->endDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['endDate']);
        $this->page = $options['page'] ?? 1;
    }

    public function getBeginDate(): Carbon
    {
        return $this->beginDate;
    }

    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}


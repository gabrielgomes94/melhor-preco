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
    private ?string $sortOption;

    public function __construct(array $options = [])
    {
        $this->beginDate = $this->getDate($options['beginDate'] ?? '01/01/1970');
        $this->endDate = $this->getDate($options['endDate'] ?? '31/12/9999');
        $this->sortOption = $options['sortOption'] ?? null;
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

    public function getSortOption(): string
    {

    }

    private function getDate(string $date): Carbon
    {
        return Carbon::createFromFormat(self::DATE_FORMAT, $date);
    }
}


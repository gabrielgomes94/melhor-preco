<?php

namespace Src\Sales\Application\UseCases\Filters;

use Carbon\Carbon;
use Src\Sales\Domain\Repositories\Contracts\Repository as RepositoryInterface;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter as ListSalesFilterInterface;

class ListSalesFilter implements ListSalesFilterInterface
{
    private const DATE_FORMAT = 'd/m/Y';

    private Carbon $beginDate;
    private Carbon $endDate;
    private int $page;
    private int $perPage = RepositoryInterface::PER_PAGE;
    private string $url;

    public function __construct(array $options = [])
    {
        $this->beginDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['beginDate'] ?? '01/01/1970');
        $this->endDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['endDate'] ?? '31/12/9999');
        $this->page = $options['page'] ?? 1;
        $this->url = $options['url'];
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

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}


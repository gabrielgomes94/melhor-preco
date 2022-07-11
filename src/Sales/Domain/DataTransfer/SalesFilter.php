<?php

namespace Src\Sales\Domain\DataTransfer;

use Carbon\Carbon;

class SalesFilter
{
    public const PER_PAGE = 40;

    private const DATE_FORMAT = 'd/m/Y';

    private Carbon $beginDate;
    private Carbon $endDate;
    private int $page;
    private int $perPage = self::PER_PAGE;
    private string $url;
    private string $userId;

    public function __construct(array $options = [])
    {
        $this->beginDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['beginDate'] ?? '01/01/1970');
        $this->endDate = Carbon::createFromFormat(self::DATE_FORMAT, $options['endDate'] ?? '31/12/9999');
        $this->page = $options['page'] ?? 1;
        $this->url = $options['url'] ?? '';
        $this->userId = $options['userId'];
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}


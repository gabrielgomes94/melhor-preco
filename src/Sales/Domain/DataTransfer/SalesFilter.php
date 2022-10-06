<?php

namespace Src\Sales\Domain\DataTransfer;

use Carbon\Carbon;

class SalesFilter
{
    public const PER_PAGE = 40;

    public const DATE_FORMAT = 'd/m/Y';

    public function __construct(
        private string $userId,
        private ?Carbon $beginDate = null,
        private ?Carbon $endDate = null,
        private ?string $url = null,
        private int $page = 1,
        private int $perPage = self::PER_PAGE,
    )
    {}


    public function getBeginDate(): ?Carbon
    {
        return $this->beginDate;
    }

    public function getEndDate(): ?Carbon
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}

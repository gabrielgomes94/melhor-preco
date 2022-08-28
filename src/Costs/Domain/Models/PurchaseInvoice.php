<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Support\Carbon;
use Src\Users\Infrastructure\Laravel\Models\User;

interface PurchaseInvoice
{
    public function getAccessKey(): string;

    public function getContactName(): string;

    public function getFiscalId(): string;

    public function getIssuedAt(): Carbon;

    public function getLastUpdate(): Carbon;

    public function getNumber(): string;

    public function getSeries(): string;

    public function getSituation(): string;

    public function getUuid(): string;

    public function getValue(): float;

    public function getXmlUrl(): string;

    public function hasItems(): bool;

    public function getItems(): iterable;

    public function getUser(): User;
}

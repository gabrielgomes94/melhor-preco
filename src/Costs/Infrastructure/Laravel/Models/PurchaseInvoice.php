<?php

namespace Src\Costs\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice as PurchaseInvoiceInterface;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;

class PurchaseInvoice extends Model implements PurchaseInvoiceInterface
{
    protected $fillable = [
        'access_key',
        'contact_name',
        'fiscal_id',
        'issued_at',
        'number',
        'series',
        'situation',
        'value',
        'xml',
        'link_danfe'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_invoices';

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_invoice_uuid', 'uuid');
    }

    public function getAccessKey(): string
    {
        return $this->access_key;
    }

    public function getFiscalId(): string
    {
        return $this->fiscal_id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getSeries(): string
    {
        return $this->series;
    }

    public function getXmlUrl(): string
    {
        return $this->xml;
    }

    public function getSupplierName(): string
    {
        return $this->getContactName();
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getIssuedAt(): Carbon
    {
        return $this->issued_at;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getSituation(): string
    {
        return $this->situation;
    }

    public function getLastUpdate(): Carbon
    {
        return $this->updated_at;
    }

    public function hasItems(): bool
    {
        return $this->items->count() > 0;
    }
}
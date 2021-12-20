<?php

namespace Src\costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
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
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_invoices';

    public function getAccessKey(): string
    {
        return $this->access_key;
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
}

<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;
use Src\Sales\Infrastructure\Laravel\Models\Casts\IdentifiersCast;
use Src\Sales\Infrastructure\Laravel\Models\Casts\SaleDatesCast;
use Src\Sales\Infrastructure\Laravel\Models\Casts\SaleValueCast;
use Src\Sales\Infrastructure\Laravel\Models\Concerns\SaleOrderGetters;
use Src\Sales\Infrastructure\Laravel\Models\Concerns\SaleOrderRelationships;
use Src\Sales\Infrastructure\Laravel\Models\Concerns\SaleOrderScopes;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrder extends Model implements SaleOrderInterface
{
    use SaleOrderGetters;
    use SaleOrderRelationships;
    use SaleOrderScopes;

    protected $casts = [
        'sale_order_id' => 'integer',
        'selled_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'expected_arrival_at' => 'datetime',
        'identifiers' => IdentifiersCast::class,
        'value' => SaleValueCast::class,
        'sale_dates' => SaleDatesCast::class,
    ];

    protected $fillable = [
        'sale_order_id',
        'purchase_order_id',
        'integration',
        'store_id',
        'store_sale_order_id',
        'selled_at',
        'dispatched_at',
        'expected_arrival_at',
        'discount',
        'freight',
        'status',
        'total_products',
        'total_profit',
        'total_value',
    ];

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getSaleValue(): SaleValue
    {
        return $this->value;
    }

    public function getSaleDates(): SaleDates
    {
        return $this->sale_dates;
    }

    public function getMarketplace(): ?Marketplace
    {
        return $this->marketplace;
    }

    public function getProfit(): ?float
    {
        return $this->total_profit;
    }

    public function getSelledAt(): ?Carbon
    {
        return $this->selled_at;
    }

    public function getLastUpdate(): Carbon
    {
        return $this->getSaleDates()->selledAt();
    }

    public function getStatus(): Status
    {
        return new Status($this->status);
    }
}

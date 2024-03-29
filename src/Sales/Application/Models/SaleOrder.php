<?php

namespace Src\Sales\Application\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;
use Src\Sales\Application\Models\Casts\IdentifiersCast;
use Src\Sales\Application\Models\Casts\SaleDatesCast;
use Src\Sales\Application\Models\Casts\SaleValueCast;
use Src\Sales\Application\Models\Concerns\SaleOrderRelationships;
use Src\Sales\Application\Models\Concerns\SaleOrderScopes;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Users\Domain\Models\User;

class SaleOrder extends Model implements SaleOrderInterface
{
    use SaleOrderRelationships;
    use SaleOrderScopes;

    protected $casts = [
        'sale_order_id' => 'integer',
        'selled_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'expected_arrival_at' => 'datetime',
        'identifiers' => IdentifiersCast::class,
        'sale_values' => SaleValueCast::class,
        'sale_dates' => SaleDatesCast::class,
    ];

    protected $fillable = [
        'sale_order_id',
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

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    protected $table = 'sales_orders';

    public function getIdentifiers(): SaleIdentifiers
    {
        return $this->identifiers;
    }

    public function getItems(): array
    {
        return $this->items->all();
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function getSaleValue(): SaleValue
    {
        return $this->sale_values;
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

    public function getSelledAt(): Carbon
    {
        return $this->selled_at;
    }

    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    public function getLastUpdate(): Carbon
    {
        return $this->updated_at;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): string
    {
        return $this->user->getId();
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice;
use Src\Sales\Domain\Factories\PaymentInstallment;
use Src\Sales\Domain\Factories\Shipment as ShipmentFactory;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice as InvoiceObject;
use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment as ShipmentData;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;


class SaleOrder extends Model implements SaleOrderInterface
{

    protected $casts = [
        'sale_order_id' => 'integer',
        'selled_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'expected_arrival_at' => 'datetime',
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

    /*********************************
     *
     *  Eloquent Relationships
     *
     *********************************/

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(\Src\Sales\Domain\Models\Invoice::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function payment(): HasMany
    {
        return $this->hasMany(\Src\Sales\Domain\Models\PaymentInstallment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    /*********************************
     *
     *  Getters
     *
     *********************************/

    public function getCustomer(): CustomerData
    {
        return CustomerFactory::make($this->customer);
    }

    public function getIdentifiers(): Identifiers
    {
        return new Identifiers(
            id: $this->sale_order_id,
            purchaseOrderId: $this->purchase_order_id,
            integration: $this->integration,
            storeId: $this->store_id,
            storeSaleOrderId: $this->store_sale_order_id);
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getInvoice(): InvoiceObject
    {
        return Invoice::make($this->invoice);
    }

    public function getPayment(): Payment
    {
        foreach ($model->payments ?? [] as $payment) {
            $instalments[] = PaymentInstallment::make($payment);
        }

        return new Payment($instalments ?? []);
    }

    public function getProfit(): ?float
    {
        return $this->total_profit;
    }

    public function getSaleValue(): SaleValue
    {
        return new SaleValue(
            discount: $this->discount,
            freight: $this->freight,
            totalProducts: $this->total_products,
            totalValue: $this->total_value
        );
    }

    public function getSaleDates(): SaleDates
    {
        return new SaleDates(
            selledAt: $this->selled_at,
            dispatchedAt: $this->dispatched_at,
            expectedArrivalAt: $this->expected_arrival_at
        );
    }

    public function getShipment(): ShipmentData
    {
        return ShipmentFactory::make($this->shipment);
    }

    public function getStatus(): Status
    {
        return new Status($this->status);
    }

    /*********************************
     *
     *  Scopes
     *
     *********************************/

    public function scopeValid($query)
    {
        return $query->where('status', '<>', 'Cancelado');
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderBy('selled_at', 'desc')
            ->orderBy('sale_order_id', 'desc');
    }
}

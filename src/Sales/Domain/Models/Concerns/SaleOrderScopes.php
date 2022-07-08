<?php

namespace Src\Sales\Domain\Models\Concerns;

trait SaleOrderScopes
{
    public function scopeValid($query)
    {
        return $query->where('status', '<>', 'Cancelado')->where('store_id', '<>', '');
    }

    public function scopeInDateInterval($query, $beginDate, $endDate)
    {
        return $query->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate);
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderBy('selled_at', 'desc')
            ->orderBy('sale_order_id', 'desc');
    }
}

<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Concerns;

use Carbon\Carbon;

trait SaleOrderScopes
{
    public function scopeValid($query)
    {
        return $query->where('status', '<>', 'Cancelado')->where('store_id', '<>', '');
    }

    public function scopeInDateInterval($query, $beginDate, $endDate)
    {
        $beginDate = $beginDate ?? Carbon::createFromFormat('d/m/Y', '01/01/1970');
        $endDate = $endDate ?? Carbon::createFromFormat('d/m/Y', '31/12/9999');

        return $query->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate);
    }

    public function scopeDefaultOrder($query)
    {
        return $query->orderBy('selled_at', 'desc')
            ->orderBy('sale_order_id', 'desc');
    }

    public function scopeInStore($query, string $marketplaceErpId)
    {
        return $query->where('store_id', $marketplaceErpId);
    }

    public function scopeFromUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }
}

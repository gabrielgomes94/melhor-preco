<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission',
        'profit',
        'store',
        'store_sku_id',
        'value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

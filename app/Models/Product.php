<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'purchase_price',
        'sku_magalu',
        'sku_b2w',
        'sku_mercado_livre',
        'tax_ipi',
        'tax_icms',
        'tax_simples_nacional',
    ];

    public function pricings()
    {
        return $this->belongsToMany(Pricing::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'sku';

    protected $fillable = [
        'sku',
        'name',
        'purchase_price',
        'tax_ipi',
        'tax_icms',
        'tax_simples_nacional',
        'additional_costs',
        'depth',
        'height',
        'width',
        'weight',
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

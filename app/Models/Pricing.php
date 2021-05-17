<?php

namespace App\Models;

use Barrigudinha\Pricing\Data\Pricing as DomainPricing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $table = 'pricing';

    protected $fillable = [
        'name',
        'stores'
    ];

    protected $casts = [
        'stores' => 'json',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pricing_products');
    }
}

<?php

namespace App\Models;

use App\Casts\Pricing\ProductIterator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'products',
        'stores',
    ];

    protected $casts = [
        'stores' => 'array',
        'products' => ProductIterator::class,
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'products',
        'stores',
    ];

    protected $casts = [
        'stores' => 'array',
        'products' => 'array',
    ];
}

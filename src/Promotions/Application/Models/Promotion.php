<?php

namespace Src\Promotions\Application\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Src\Math\Percentage;
use Src\Promotions\Domain\Models\Promotion as PromotionInterface;

class Promotion extends Model implements PromotionInterface
{
    public $incrementing = false;

    protected $fillable = [
        'name',
        'products',
        'discount',
        'begin_date',
        'end_date',
        'max_products_limit',
    ];

    protected $casts = [
        'products' => 'json',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function getProducts()
    {
        return $this->products;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiscount(): Percentage
    {
        return $this->discount;
    }

    public function getBeginDate(): DateTime
    {
        return $this->begin_date;
    }

    public function getEndDate(): DateTime
    {
        return $this->end_date;
    }

    public function getProductsLimit(): int
    {
        return $this->max_products_limit;
    }
}

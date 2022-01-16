<?php

namespace Src\Products\Domain\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Products\Domain\Models\Product\Product;

class Category extends Model
{
    public $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'category_id',
        'parent_category_id',
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'parent_category_id');
    }

    public function getCategoryId(): string
    {
        return $this->category_id;
    }
}

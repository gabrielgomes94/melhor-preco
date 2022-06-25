<?php

namespace Src\Products\Infrastructure\Laravel\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Products\Domain\Models\Category as CategoryInterface;
use Src\Products\Domain\Models\Product\Product;

class Category extends Model implements CategoryInterface
{
    public $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

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
        return $this->belongsTo(Category::class, 'parent_category_id', 'category_id');
    }

    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    public function getFullName(): string
    {
        $parentModel = $this->parent;
        $parentNames[] = $this->name;

        do {
            if ($parentModel?->name) {
                $parentNames[] = $parentModel?->name;
            }

            $parentModel = $parentModel?->parent;
        } while ($parentModel);

        if (count($parentNames) == 1) {
            return implode('', $parentNames);
        }

        return implode(' / ', array_reverse($parentNames));
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function getParentId(): string
    {
        return $this?->parent?->getCategoryId() ?? '';
    }
}

<?php

namespace Src\Products\Infrastructure\Laravel\Models\Categories;

use Ramsey\Uuid\Uuid;

class CategoryObserver
{
    public function creating(Category $model)
    {
        $model->uuid = Uuid::uuid4();
    }
}

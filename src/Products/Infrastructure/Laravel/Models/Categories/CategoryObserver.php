<?php

namespace Src\Products\Infrastructure\Laravel\Models\Categories;

use Ramsey\Uuid\Uuid;

/**
 * @todo: refatorar a criação de UUID buscando remover esse Observer
 */
class CategoryObserver
{
    public function creating(Category $model)
    {
        $model->uuid = Uuid::uuid4();
    }
}

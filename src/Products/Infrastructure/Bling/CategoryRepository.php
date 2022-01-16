<?php

namespace Src\Products\Infrastructure\Bling;

use Src\Integrations\Bling\Categories\Client;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Repositories\Contracts\Erp\ErpCategoryRepository;

class CategoryRepository implements ErpCategoryRepository
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        $categories = [];
        $page = 0;

        do {
            $data = $this->client->list(++$page);
            $categories = array_merge($categories, $data);
        } while (!empty($data));

        foreach ($categories as $category) {
            $categoriesList[] = new Category([
                'category_id' => $category['id'],
                'parent_category_id' => $category['idCategoriaPai'],
                'name' => $category['descricao'],
            ]);
        }

        return $categoriesList ?? [];
    }
}

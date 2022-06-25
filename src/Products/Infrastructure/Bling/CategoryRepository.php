<?php

namespace Src\Products\Infrastructure\Bling;

use Src\Integrations\Bling\Categories\Client;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\Contracts\Erp\CategoryRepository as CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(string $erpToken): array
    {
        $categories = [];
        $page = 0;

        do {
            $data = $this->client->list($erpToken, ++$page);
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

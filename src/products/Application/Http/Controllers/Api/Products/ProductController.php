<?php

namespace Src\Products\Application\Http\Controllers\Api\Products;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Integrations\Bling\Products\Repositories\Repository;
use Integrations\Bling\Products\Responses\Error;

use function response;

class ProductController extends BaseController
{
    private Repository $erpRepository;

    public function __construct(Repository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function get(Request $request, $sku): JsonResponse
    {
        $response = $this->erpRepository->get($sku);

        if ($response instanceof Error) {
            $errors = $this->transformErrors($response->errors());
            return response()->json(compact('errors'), 404);
        }

        $product = $this->transform($response->data()->toArray());

        return response()->json(compact('product'));
    }

    private function transform(array $data): array
    {
        return [
            'sku' => $data['sku'],
            'name' => $data['name'],
            'brand' => $data['brand'],
            'images' => $data['images'] ?? [],
            'stock' => $data['stock'] ?? null,
        ];
    }

    private function transformErrors(array $errors): string
    {
        return array_shift($errors);
    }
}

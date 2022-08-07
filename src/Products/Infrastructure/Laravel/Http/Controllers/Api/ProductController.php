<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Products\Infrastructure\Bling\ProductRepository;

class ProductController extends Controller
{
    private ProductRepository $erpRepository;

    public function __construct(ProductRepository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function get(string $sku): JsonResponse
    {
        $erpToken = $this->getUserErpToken();
        $response = $this->erpRepository->get($erpToken, $sku);

        if ($response instanceof ErrorResponse) {
            $errors = $this->transformErrors($response->errors());

            return response()->json(compact('errors'), 404);
        }

        $product = $this->transform($response->data()[0]->toArray());

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

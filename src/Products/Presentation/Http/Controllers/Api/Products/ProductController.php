<?php

namespace Src\Products\Presentation\Http\Controllers\Api\Products;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Products\Infrastructure\Bling\ProductRepository;

// @deprecated
class ProductController extends BaseController
{
    private ProductRepository $erpRepository;

    public function __construct(ProductRepository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    /**
     * @TODO: Mover a lógica para uma classe de UseCase
     * @param Request $request
     * @param $sku
     * @return JsonResponse
     */
    public function get(Request $request, $sku): JsonResponse
    {
        $response = $this->erpRepository->get($sku);

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

<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Products\Infrastructure\Bling\ProductRepository;

class ProductController extends Controller
{
    private ProductRepository $erpRepository;

    public function __construct(ProductRepository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function get(Request $request, string $sku)
    {
        $response = $this->erpRepository->get($sku);

        if ($response instanceof ErrorResponse) {
            $errors = $this->transformErrors($response->errors());

            return view('pages.products.reports.get_with_stock', ['errors' => $errors]);
        }

        $product = $this->transform($response->data()->toArray());

        return view('pages.products.reports.get_with_stock', ['product' => $product]);
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

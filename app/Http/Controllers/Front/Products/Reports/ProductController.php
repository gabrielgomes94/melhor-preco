<?php

namespace App\Http\Controllers\Front\Products\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Integrations\Bling\Products\Repositories\Repository;
use Integrations\Bling\Products\Responses\Error;

class ProductController extends Controller
{
    private Repository $erpRepository;

    public function __construct(Repository $erpRepository)
    {
        $this->erpRepository = $erpRepository;
    }

    public function get(Request $request, string $sku)
    {
        $response = $this->erpRepository->get($sku);

        if ($response instanceof Error) {
            $errors = $this->transformErrors($response->errors());

            return view('pages.products.repo rts.get_with_stock', ['errors' => $errors]);
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

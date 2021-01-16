<?php
namespace App\Http\Controllers\Front;

use App\Bling\Product\Client;
use App\Http\Transformers\ProductTransformer;
use App\Bling\Product\Services\Product as ProductService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    /**
     * @var Client
     */
    private $blingClient;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var ProductTransformer
     */
    private $transformer;

    public function __construct(Client $blingClient, ProductService $productService, ProductTransformer $transformer)
    {
        $this->blingClient = $blingClient;
        $this->productService = $productService;
        $this->transformer = $transformer;
    }

    public function getWithStock(Request $request, $sku)
    {
        $response = $this->productService->get($sku, 'stock');
        $data = $this->transformer->transform($response);

        if (!empty($data['products'])) {
            $product = $data['products'][0];

            return view('products/get_with_stock', ['product' => $product]);
        }

        $errors = $data['errors'] ?? '';

        return view('products/get_with_stock', ['errors' => $errors]);
    }
}

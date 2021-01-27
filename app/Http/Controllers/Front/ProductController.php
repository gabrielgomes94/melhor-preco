<?php
namespace App\Http\Controllers\Front;

use App\Bling\Product\Client;
use App\Bling\Product\Services\GenerateQRCode;
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

    public function get(Request $request, $sku)
    {
        $response = $this->productService->get($sku);
        $data = $this->transformer->transform($response);

        if (!empty($data['products'])) {
            $product = $data['products'][0];

            return view('products/get_with_stock', ['product' => $product]);
        }

        $errors = $data['errors'] ?? '';

        return view('products/get_with_stock', ['errors' => $errors]);
    }

    public function createQrCode(Request $request)
    {
        return view('products/generate_qr_code');
    }

    public function generateQrCode(Request $request)
    {
        $qrCodeService = new GenerateQRCode();
        $products = $request->input('products');
        $qrCodes = $qrCodeService->generate($products);

        return view('products/qr_codes/list', ['products' => $qrCodes]);
    }
}

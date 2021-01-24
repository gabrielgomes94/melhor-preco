<?php
namespace App\Http\Controllers\Front\Products;

use App\Barrigudinha\Product\Product;
use App\Bling\Product\Services\ImageStorage;
use App\Bling\Product\Services\ProductUpdater;
use App\Http\Requests\ImageUploaderRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductImageController extends BaseController
{
    /**
     * @var ProductUpdater
     */
    private $productService;

    /**
     * @var ImageStorage
     */
    private $imageService;

    public function __construct(ProductUpdater $productService, ImageStorage $imageService)
    {
        $this->productService = $productService;
        $this->imageService = $imageService;
    }

    public function upload(ImageUploaderRequest $request)
    {
        $data = $this->transformData($request);
        $product = new Product($data);

        $files = $request->file()['file'];
        $urls = $this->imageService->store($product, $files);

        $product->addImages($urls);

        $this->productService->update($product);

        return redirect()->route('product.images.upload_form',
            [
                'data' => [
                    'message' => 'Upload feito com sucesso.'
                ]
            ]);
    }

    public function uploadImage(Request $request)
    {
        return view('products/images/upload-images');
    }

    private function transformData(ImageUploaderRequest $request): array
    {
        return [
            'sku' => $request->input('sku'),
            'name' => $request->input('description'),
            'brand' => $request->input('brand'),
            'images' => [],
        ];
    }
}

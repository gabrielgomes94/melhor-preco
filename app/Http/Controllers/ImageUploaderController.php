<?php
namespace App\Http\Controllers;

use App\Bling\Data\Product;
use App\Bling\Services\ImageStorage;
use App\Bling\Services\ProductUpdater;
use App\Http\Requests\ImageUploaderRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class ImageUploaderController extends BaseController
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

        return redirect()->route('sucesso');
    }

    private function transformData(ImageUploaderRequest $request): array
    {
        return [
            'code' => $request->input('codigo'),
            'name' => $request->input('descricao'),
            'brand' => $request->input('marca'),
            'images' => [],
        ];
    }
}

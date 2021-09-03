<?php

namespace App\Http\Controllers\Front\Products;

use App\Barrigudinha\Product\Product;
use App\Bling\Product\Services\ImageStorage;
use App\Bling\Product\Services\ProductUpdater;
use App\Http\Requests\ImageUploaderRequest;
use App\Services\Product\Images\StoreImages;
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

    private StoreImages $storeImages;

    public function __construct(ProductUpdater $productService, ImageStorage $imageService, StoreImages $storeImages)
    {
        $this->productService = $productService;
        $this->imageService = $imageService;
        $this->storeImages = $storeImages;
    }

    public function upload(ImageUploaderRequest $request)
    {
        $sku = $request->input('sku');
        $files = $request->file()['file'];

        try {
            $this->storeImages->execute($sku, $files);
            session()->flash('message', 'Fotos atualizadas com sucesso.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('product.images.upload_form');
    }

    public function uploadImage(Request $request)
    {
        return view('pages.products/images/upload-images');
    }
}

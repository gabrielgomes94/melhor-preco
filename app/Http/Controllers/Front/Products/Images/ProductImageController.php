<?php

namespace App\Http\Controllers\Front\Products\Images;

use App\Http\Requests\ImageUploaderRequest;
use App\Services\Product\Images\StoreImages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use function redirect;
use function session;
use function view;

class ProductImageController extends BaseController
{
    private StoreImages $storeImages;

    public function __construct(StoreImages $storeImages)
    {
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

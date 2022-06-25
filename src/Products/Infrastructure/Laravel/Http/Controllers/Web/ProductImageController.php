<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use Src\Products\Infrastructure\Laravel\Http\Requests\ImageUploaderRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Src\Products\Application\UseCases\UploadImages;

class ProductImageController extends BaseController
{
    private UploadImages $storeImages;

    public function __construct(UploadImages $storeImages)
    {
        $this->storeImages = $storeImages;
    }

    public function upload(ImageUploaderRequest $request)
    {
        try {
            $user = $request->user();

            $this->storeImages->execute(
                $user->getErpToken(),
                $request->validated()['sku'],
                $request->validated()['name'],
                $request->validated()['brand'],
                $request->validated()['images'],
            );

            session()->flash('message', 'Fotos atualizadas com sucesso.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return view('pages.products.images.upload-images');
    }

    public function uploadImage(Request $request)
    {
        return view('pages.products/images/upload-images');
    }
}

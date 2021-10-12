<?php

namespace Src\Products\Application\Http\Controllers\Web\Images;

use App\Http\Requests\ImageUploaderRequest;
use Src\Products\Application\Services\Images\StoreImages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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
        try {
            $this->storeImages->execute(
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

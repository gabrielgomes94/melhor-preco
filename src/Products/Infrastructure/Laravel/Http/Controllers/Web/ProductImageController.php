<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Products\Domain\Services\UploadImages;
use Src\Products\Infrastructure\Laravel\Http\Requests\ImageUploaderRequest;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(
        private UploadImages $uploadImages
    )
    {}

    public function upload(ImageUploaderRequest $request)
    {
        try {
            $this->uploadImages->execute($request->transform(), $this->getUser());

            session()->flash('message', 'Fotos atualizadas com sucesso.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return view('pages.products.upload-images.form');
    }

    public function uploadImage(Request $request)
    {
        return view('pages.products.upload-images.form');
    }
}

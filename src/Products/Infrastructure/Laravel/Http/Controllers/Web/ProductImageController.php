<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Src\Products\Domain\Services\UploadImages;
use Src\Products\Infrastructure\Laravel\Http\Requests\ImageUploaderRequest;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(
        private UploadImages $uploadImages
    )
    {}

    public function upload(ImageUploaderRequest $request): View|Factory
    {
        $result = $this->uploadImages->execute(
            $request->transform(),
            $this->getUser()
        );

        if ($result) {
            session()->flash('message', 'Fotos atualizadas com sucesso.');
        } else {
            session()->flash('error', 'Erro: produto não foi enviado para o Bling.');
        }

        return view('pages.products.upload-images.form');
    }

    public function uploadImage(Request $request): View|Factory
    {
        return view('pages.products.upload-images.form');
    }
}

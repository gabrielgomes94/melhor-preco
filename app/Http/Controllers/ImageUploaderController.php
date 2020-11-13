<?php
namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Bling\ProductService;

class ImageUploaderController extends BaseController
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return view('upload-images', ['errorMsg' => 'Erro: selecione as imagens antes de enviar']);
        }

        $files = $request->file()['file'];

        $sku = $request->input('codigo');
        $name = $this->getName($sku, $request->input('descricao'));
        $path = "{$request->input('marca')}/{$name}";

        $urls = $this->storeImages($files, $path);
        $this->productService->uploadImages($request->all(), $urls);

        return response()->redirectTo('/sucesso');
    }

    private function getName($sku, $name)
    {
        $nameSanitized = preg_replace('/\//', '',  $name);
        return $sku . " - " . $nameSanitized;
    }

    private function storeImages(array $files, $path)
    {
        $urls = [];
        foreach ($files as $file) {
            $url = Storage::putFileAs($path, $file, $file->getClientOriginalName(), 'public');

            $urls[] = Storage::url(urlencode($url));
        }

//        dd($urls);

        return $urls;
    }
}

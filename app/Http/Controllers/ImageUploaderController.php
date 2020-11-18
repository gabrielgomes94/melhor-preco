<?php
namespace App\Http\Controllers;

use App\Http\Requests\ImageUploaderRequest;
use Illuminate\Routing\Controller as BaseController;
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

    public function upload(ImageUploaderRequest $request)
    {
        if (!$request->hasFile('file')) {
            return view('upload-images', [
                'errorMsg' => 'Erro: selecione as imagens antes de enviar',
            ]);
        }

        $files = $request->file()['file'];

        $path = $this->getPath($request);
        $urls = $this->storeImages($files, $path);
        $this->productService->uploadImages($request->all(), $urls);

        return redirect()->route('sucesso');
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

        return $urls;
    }

    private function getPath($request)
    {
        $sku = $request->input('codigo');
        $name = $this->getName($sku, $request->input('descricao'));
        $path = "{$request->input('marca')}/{$name}";

        return $path;
    }
}

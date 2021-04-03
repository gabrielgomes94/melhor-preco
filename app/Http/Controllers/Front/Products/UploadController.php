<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Services\Product\ImportSpreadsheet;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private ImportSpreadsheet $importService;

    public function __construct(ImportSpreadsheet $importService)
    {
        $this->importService = $importService;
    }

    public function upload()
    {
        return view('products/upload/upload');
    }

    public function doUpload(Request $request)
    {
        $inputFile = $request->file('file');

        $this->importService->execute($inputFile[0]);
    }
}

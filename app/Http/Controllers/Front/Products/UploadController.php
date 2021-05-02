<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Services\Product\ImportICMS;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private ImportICMS $importService;

    public function __construct(ImportICMS $importService)
    {
        $this->importService = $importService;
    }

    public function updateICMS()
    {
        return view('products/upload/upload');
    }

    public function doUpdateICMS(Request $request)
    {
        $inputFile = $request->file('file');

        $this->importService->execute($inputFile[0]);

        return view('products/upload/upload');
    }
}

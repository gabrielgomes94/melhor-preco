<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload()
    {
        return view('products/upload/upload');
    }

    public function doUpload(Request $request)
    {
        dd('pare aqui');
        dd($request);
    }
}

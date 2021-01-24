<?php
namespace App\Http\Controllers\Front\Products;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductImageController extends BaseController
{
    public function uploadImage(Request $request)
    {
        return view('products/images/upload-images');
    }

}

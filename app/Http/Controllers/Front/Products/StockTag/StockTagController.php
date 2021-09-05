<?php

namespace App\Http\Controllers\Front\Products\StockTag;

use App\Http\Controllers\Controller;
use App\Services\Product\StockTag\GenerateQRCode;
use Illuminate\Http\Request;

class StockTagController extends Controller
{
    private GenerateQRCode $generateQRCodeService;

    public function __construct(GenerateQRCode $generateQRCodeService)
    {
        $this->generateQRCodeService = $generateQRCodeService;
    }

    public function createQrCode(Request $request)
    {
        return view('pages.products/generate_qr_code');
    }

    public function generateQrCode(Request $request)
    {
        $products = $request->input('products');
        $qrCodes = $this->generateQRCodeService->generate($products);

        return view('pages.products/qr_codes/list', ['products' => $qrCodes]);
    }
}
